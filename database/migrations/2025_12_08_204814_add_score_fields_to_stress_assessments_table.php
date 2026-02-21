<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('stress_assessments', function (Blueprint $table) {
        $table->integer('numeric_score')->nullable();
        $table->string('stress_category')->nullable();
    });
}

public function down()
{
    Schema::table('stress_assessments', function (Blueprint $table) {
        $table->dropColumn(['numeric_score', 'stress_category']);
    });
}
};