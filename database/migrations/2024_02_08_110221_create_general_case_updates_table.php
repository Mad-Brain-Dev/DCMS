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
        Schema::create('general_case_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->nullable();
            $table->string('gn_update')->nullable();
            $table->text('gn_summary')->nullable();
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
        Schema::dropIfExists('general_case_updates');
    }
};
