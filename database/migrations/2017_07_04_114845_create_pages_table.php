<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('last_edited_by')->unsigned();
            $table->smallInteger('type')->unsigned();
            $table->boolean('logged_in');
            $table->string('title');
            $table->text('content');

            $table->timestamps();


            $table->foreign('last_edited_by')->references('id')->on('users')->onDelete('cascade');
        });

        \Illuminate\Support\Facades\DB::table('pages')->insert(
            array(
                'last_edited_by' => 1,
                'type' => 1,
                'logged_in' => 0,
                'title' => 'Welkom bij CRPG',
                'content' => 'Lorem ipsum',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
