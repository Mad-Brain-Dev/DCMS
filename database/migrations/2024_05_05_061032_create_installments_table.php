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
            $table->foreignId('debtor_id')->nullable()->references('id')->on('debtors')
                ->onDelete('cascade');
            $table->decimal('amount_paid',15,2)->nullable();
            $table->foreignId('collected_by_id')->references('id')->on('users')
            ->onDelete('cascade');
            // $table->string('save_by_user_type')->nullable();
            $table->float('next_payment_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('snapshot_total_paid', 15, 2)->nullable();
            $table->decimal('snapshot_total_balance', 15, 2)->nullable();
            $table->decimal('snapshot_total_debt', 15, 2)->nullable();
            $table->decimal('balance_before', 15, 2)->nullable();
            $table->string('update_type')->nullable();
            $table->string('assign_type')->nullable();
            $table->string('fv_date')->nullable();
            $table->string('status')->default('not_complete');
            $table->dateTime('date_of_payment')->nullable();
            $table->dateTime('next_payment_date')->nullable();
            $table->string('underInstallment')->nullable();
            $table->string('pay_to_who')->nullable();
            $table->boolean('is_invoiced')->default(false);
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
