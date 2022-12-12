<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // データ型をdateTime型からdate型へ変更
            $table->date("birthdate")->change();
            $table->date("enrollment_date")->change();
            $table->date("expel_date")->nullable()->change();
            $table->date("trial_lesson_date")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // データ型をdate型からdateTime型へ戻す
            $table->dateTime("birthdate")->change();
            $table->dateTime("enrollment_date")->change();
            $table->dateTime("expel_date")->nullable()->change();
            $table->dateTime("trial_lesson_date")->nullable()->change();
        });
    }
};
