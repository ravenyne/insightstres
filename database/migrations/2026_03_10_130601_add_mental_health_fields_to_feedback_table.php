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
        Schema::table('feedback', function (Blueprint $table) {
            // Drop enum type and add string type for categories
            $table->dropColumn('type');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->string('type')->after('user_id')->default('pengalaman_assessment');
            $table->string('stress_condition')->nullable()->after('type');
            $table->string('related_feature')->nullable()->after('stress_condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn(['stress_condition', 'related_feature']);
            $table->dropColumn('type');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->enum('type', ['bug', 'feature', 'improvement', 'other'])->default('bug');
        });
    }
};
