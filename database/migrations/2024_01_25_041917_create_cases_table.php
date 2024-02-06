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
            $table->string('case_number');
            $table->string('current_status');
            $table->dateTime('date_of_agreement');
            $table->dateTime('date_of_expiry');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('client_id');
            $table->string('collection_commission');
            $table->string('field_visit');
            $table->string('bal_field_visit');
            $table->string('manager_ic');
            $table->string('collector_ic');
            $table->string('name');
            $table->string('nric')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_uen')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('adderss');
            $table->string('debt_amount');
            $table->string('legal_cost');
            $table->string('debt_interest');
            $table->dateTime('interest_start_date');
            $table->dateTime('interest_end_date');
            $table->string('total_interest');
            $table->string('total_amount_owed');
            $table->string('total_amount_paid');
            $table->string('total_amount_balance');
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
