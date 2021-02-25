<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiFileTable extends Migration
{
    public function up()
    {
        Schema::create('wiki_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_wiki')->unsigned();
            $table->string('type',40);
            $table->string('type')->nullable();
            $table->string('path');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wiki_files');
    }
}
