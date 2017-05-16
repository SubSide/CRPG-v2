<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dungeon_master')->unsigned();
            $table->string('title');
            $table->dateTime('date');
            $table->time('approx_time');
            $table->text('prologue');
            $table->text('gametype');
            $table->integer('max_players');
            $table->string('round');
            $table->timestamps();


            $table->foreign('dungeon_master')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
