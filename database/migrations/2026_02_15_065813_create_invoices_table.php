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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')->unique();

            $table->foreignId('client_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('invoice_date')->nullable();
            $table->date('issued_date')->nullable();

            // Totals
            $table->decimal('total_collected_client', 15, 2)->default(0);
            $table->decimal('total_collected_securre', 15, 2)->default(0);

            $table->decimal('payable_to_client', 15, 2)->default(0);
            $table->decimal('payable_to_securre', 15, 2)->default(0);

            $table->decimal('final_invoice_amount', 15, 2)->default(0);

            $table->enum('final_payable_to', ['client', 'securre']);

            $table->enum('status', ['issued', 'paid', 'cancelled'])
                ->default('issued');

            $table->timestamp('paid_at')->nullable();
            $table->foreignId('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->text('remarks')->nullable();

            $table->integer('year');
            $table->integer('sequence_number');
            $table->unique(['client_id', 'year', 'sequence_number']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
