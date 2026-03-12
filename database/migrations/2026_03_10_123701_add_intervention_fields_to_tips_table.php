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
        Schema::table('tips', function (Blueprint $table) {
            $table->enum('target_condition', ['Distress', 'Eustress', 'Semua Kondisi'])->default('Semua Kondisi');
            $table->boolean('is_evidence_based')->default(false);
            $table->integer('read_duration')->nullable()->comment('in minutes');
            $table->boolean('is_ai_recommended')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['target_condition', 'is_evidence_based', 'read_duration', 'is_ai_recommended']);
        });
    }
};
