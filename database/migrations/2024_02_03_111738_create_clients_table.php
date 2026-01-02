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
            $table->foreignId('user_id');
            $table->string('name')->nullable();
            $table->string('abbr')->nullable();
            $table->foreignId('collected_by_id')->default(2);
            $table->string('nric')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_uen')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('date_of_agreement')->nullable();
            $table->dateTime('date_of_expiry')->nullable();
            $table->string('admin_fee')->nullable();
            $table->string('admin_fee_paid')->nullable();
            $table->string('admin_fee_balance')->nullable();
            // $table->string('administrative_fee')->nullable();
            // $table->string('enforcement_fee')->nullable();
            // $table->string('professional_fee')->nullable();
            // $table->string('annual_fee')->nullable();
            // $table->string('skip_tracing_fee')->nullable();
            // $table->string('overseas_allowance')->nullable();
            $table->string('collection_commission')->nullable();
            $table->string('field_visit_per_case')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_number')->nullable();
            $table->string('pic_email')->nullable();
            $table->string('account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('payment_methods')->nullable();
//            $table->string('payment_terms')->nullable();
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
