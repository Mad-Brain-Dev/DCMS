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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->nullable();
            $table->string('remarks')->nullable();
            $table->string('case_sku')->nullable();
            $table->string('current_status')->nullable();
            $table->string('case_summary')->nullable();
            $table->dateTime('date_of_warrant')->nullable();
            //for client name
            $table->foreignId('client_id')->nullable();
            //for client details
            // $table->foreignId('user_id')->nullable();
            $table->string('collection_commission')->nullable();
            $table->string('field_visit')->nullable();
            $table->string('bal_field_visit')->nullable();
            $table->string('manager_ic')->nullable();
            $table->string('collector_ic')->nullable();
            $table->string('name')->nullable();
            $table->string('nric')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_uen')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('adderss')->nullable();
            $table->string('debt_amount')->nullable();
            $table->string('legal_cost')->nullable();
            $table->string('amount_unpaid')->nullable();
            $table->string('debt_interest')->nullable();
            $table->dateTime('interest_start_date')->nullable();
            $table->dateTime('fv_date')->nullable();
            $table->dateTime('next_payment_date')->nullable();
            $table->dateTime('interest_end_date')->nullable();
            $table->string('total_interest')->nullable();
            $table->string('total_amount_owed')->nullable();
            $table->string('total_amount_paid')->nullable();
            $table->string('next_payment_amount')->nullable();
            $table->string('total_amount_balance')->nullable();
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
