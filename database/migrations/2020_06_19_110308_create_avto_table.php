<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvtoTable extends Migration
{
    public function up()
    {
        Schema::create('avtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',6);
            $table->string('model',30);
            $table->string('driver',30);
            $table->string('carphoto');
            $table->string('phone_driver',10)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avtos');
    }
}
