<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoorderTable extends Migration
{
    public function up()
    {
        Schema::create('photoorders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('view');
            $table->integer('num');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('photoorders');
    }
}
