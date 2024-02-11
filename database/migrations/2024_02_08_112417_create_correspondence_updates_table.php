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
        Schema::create('correspondence_updates', function (Blueprint $table) {
            $table->id();
            $table->string('cr_update')->nullable();
            $table->foreignId('case_id')->nullable();
            $table->dateTime('fv_date')->nullable();
            $table->string('cr_summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondence_updates');
    }
};
