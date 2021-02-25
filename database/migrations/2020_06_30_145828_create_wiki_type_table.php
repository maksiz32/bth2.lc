<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiTypeTable extends Migration
{
    public function up()
    {
        Schema::create('wiki_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_system')->unsigned();
            $table->string('type');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wiki_types');
    }
}
