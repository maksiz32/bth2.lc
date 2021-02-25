<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiTable extends Migration
{
    public function up()
    {
        Schema::create('wikis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_systems')->unsigned();
            $table->integer('id_types')->unsigned();
            $table->string('error');
            $table->text('fix');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wikis');
    }
}
