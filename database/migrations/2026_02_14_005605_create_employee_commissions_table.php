<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_commissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->unsignedBigInteger('installment_id')->nullable();

            $table->decimal('collection_amount', 15, 2);
            $table->decimal('commission_rate', 15, 2);
            $table->decimal('commission_amount', 15, 2);

            $table->string('commission_month', 7); // format: YYYY-MM

            $table->enum('status', ['pending', 'paid'])->default('pending');

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unique(['employee_id', 'installment_id'], 'employee_installment_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_commissions');
    }
};
