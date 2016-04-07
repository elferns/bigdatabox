<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation', function(Blueprint $table){
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->string('name', 255);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->index('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navigation');
    }
}
