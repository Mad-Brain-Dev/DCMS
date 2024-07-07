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
        Schema::create('admin_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('collected_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('admin_fee_amount')->nullable();
            $table->timestamp('collection_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_fees');
    }
};
