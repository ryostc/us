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
            // データ型をnullableにする
            $table->string("guardian_firstname")->nullable()->change();
            $table->string("guardian_lastname")->nullable()->change();
            $table->string("guardian_firstname_ruby")->nullable()->change();
            $table->string("guardian_lastname_ruby")->nullable()->change();
            $table->string("relationship")->nullable()->change();
            $table->text("address_building")->nullable()->change();
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
            // データ型をnullableでなくdefaultを設定した状態に戻す
            $table->string("guardian_firstname")->default("")->change();
            $table->string("guardian_lastname")->default("")->change();
            $table->string("guardian_firstname_ruby")->default("")->change();
            $table->string("guardian_lastname_ruby")->default("")->change();
            $table->string("relationship")->default("")->change();
            // データ型のnullableを解除する
            $table->text("address_building")->change();
        });
    }
};
