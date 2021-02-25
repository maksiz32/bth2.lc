<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBrfirms extends Migration
{
    public function up()
    {
        Schema::create('brfirms', function (Blueprint $table) {
            $table->increments('skk');
            $table->string('name');
            $table->unsignedTinyInteger('isblock');
            $table->timestamps();
            $table->index(['skk','name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('brfirms');
    }
}
