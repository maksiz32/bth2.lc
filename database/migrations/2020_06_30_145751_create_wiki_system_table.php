<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiSystemTable extends Migration
{
    public function up()
    {
        Schema::create('wiki_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wiki_systems');
    }
}
