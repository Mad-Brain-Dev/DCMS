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
        Schema::create('field_visit_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->nullable()->references('id')->on('cases')
            ->onDelete('cascade');
            $table->foreignId('installment_id')->nullable();
            $table->string('fv_update')->nullable();
            $table->string('update_type')->default('field_visit');
            $table->string('fv_summary')->nullable();
            $table->dateTime('fv_date')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_visit_updates');
    }
};
