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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->nullable();
            $table->string('nric')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_uen')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->dateTime('date_of_agreement');
            $table->dateTime('date_of_expiry');
            $table->string('admin_fee');
            $table->string('admin_fee_paid');
            $table->string('admin_fee_balance');
            $table->string('collection_commission');
            $table->string('field_visit_per_case');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
