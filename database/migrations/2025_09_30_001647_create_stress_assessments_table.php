<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stress_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->integer('gender');
            $table->integer('age');
            $table->integer('stress_recent');
            $table->integer('heartbeat');
            $table->integer('anxiety');
            $table->integer('sleep_problems');
            $table->integer('anxiety_2');
            $table->integer('headache');
            $table->integer('irritated');
            $table->integer('concentration');
            $table->integer('sadness');
            $table->integer('illness');
            $table->integer('lonely');
            $table->integer('overwhelmed');
            $table->integer('competition');
            $table->integer('relationship_stress');
            $table->integer('professor_difficulty');
            $table->integer('work_env');
            $table->integer('relaxation_time');
            $table->integer('home_env');
            $table->integer('conf_academic');
            $table->integer('conf_subject');
            $table->integer('activity_conflict');
            $table->integer('attendance');
            $table->integer('weight_change');

            $table->integer('predicted_stress'); // hasil ML

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stress_assessments');
    }
};