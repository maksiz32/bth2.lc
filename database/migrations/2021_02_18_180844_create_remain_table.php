<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemainTable extends Migration
{
    public function up()
    {
        Schema::create('remains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tech_id');
            $table->integer('count');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remains');
    }
}
