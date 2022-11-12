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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->comment('ユーザーID')->index();
            $table->date('working_date')->comment('勤務日')->index();
            $table->time('in_time')->comment('')->nullable(false);
            $table->time('out_time')->comment('')->nullable(false);
            $table->time('rest_time')->comment('')->nullable(false);
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
        Schema::dropIfExists('attendances');
    }
};
