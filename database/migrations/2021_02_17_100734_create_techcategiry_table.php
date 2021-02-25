<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechcategiryTable extends Migration
{
    public function up()
    {
        Schema::create('techscategory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('techscategory');
    }
}
