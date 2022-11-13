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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("firstname");
            $table->string("lastname");
            $table->string("firstname_ruby");
            $table->string("lastname_ruby");
            $table->string("sex");
            $table->dateTime("birthdate");
            $table->string("guardian_firstname")->default("");
            $table->string("guardian_lastname")->default("");
            $table->string("guardian_firstname_ruby")->default("");
            $table->string("guardian_lastname_ruby")->default("");
            $table->string("relationship")->default("");
            $table->string("postcode", 8);
            $table->text("prefectures");
            $table->text("municipalities");
            $table->text("address_building");
            $table->string("phonenumber");
            $table->string("email")->default("");
            $table->text("comment"); // 入力なしの時に何かを代入する
            $table->integer("instructor_id");
            $table->string("terms_payment");
            $table->boolean("unpaid");
            $table->string("status");
            $table->string("lesson_type");
            $table->integer("pair_id")->default(-1);
            $table->dateTime("enrollment_date");
            $table->dateTime("expel_date")->nullable();
            $table->dateTime("trial_lesson_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
