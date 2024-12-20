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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->nullable()->references('id')->on('cases')
            ->onDelete('cascade');
            $table->float('amount_paid')->nullable();
            $table->foreignId('collected_by_id')->default(2)->references('id')->on('users')
            ->onDelete('cascade');
            // $table->string('save_by_user_type')->nullable();
            $table->float('next_payment_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('assign_type')->nullable();
            $table->string('fv_date')->nullable();
            $table->timestamp('date_of_payment')->nullable();
            $table->dateTime('next_payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
