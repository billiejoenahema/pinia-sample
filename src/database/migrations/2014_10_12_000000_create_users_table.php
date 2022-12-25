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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('ユーザー');
            $table->id();
            $table->string('name')->comment('名前');
            $table->string('kana_name')->comment('ふりがな');
            $table->date('birth_date')->comment('生年月日');
            $table->string('avatar')->comment('アイコン');
            $table->string('email')->comment('メールアドレス')->unique();
            $table->string('phone')->comment('電話番号')->nullable();
            $table->string('zipcode')->comment('郵便番号')->nullable();
            $table->tinyInteger('pref')->comment('都道府県')->nullable();
            $table->string('city')->comment('市区町村')->nullable();
            $table->string('street')->comment('番地')->nullable();
            $table->string('remarks')->comment('備考')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
