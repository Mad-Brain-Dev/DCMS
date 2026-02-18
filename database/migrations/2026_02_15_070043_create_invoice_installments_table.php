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
        Schema::create('invoice_installments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('installment_id')
                ->constrained()
                ->onDelete('cascade');

            // Snapshot fields
            $table->decimal('amount_paid', 15, 2);

            $table->decimal('commission_rate', 5, 2); // 40.00 for 40%

            $table->decimal('commission_amount', 15, 2);

            $table->decimal('net_amount', 15, 2);
            $table->decimal('total_debt_snapshot', 15, 2);
            $table->decimal('balance_snapshot', 15, 2);

            $table->enum('collected_type', ['client', 'securre']);

            $table->timestamps();

            $table->unique(['invoice_id', 'installment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_installments');
    }
};
