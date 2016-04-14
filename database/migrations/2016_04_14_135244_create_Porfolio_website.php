<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorfolioWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_websites', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 255);
            $table->string('url', 512);
            $table->text('description');
            $table->string('image_name', 255);
            $table->date('launch_date');
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('portfolio_websites');
    }
}
