<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechTable extends Migration
{
    public function up()
    {
        Schema::create('techs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo');
            $table->string('tech');
            $table->string('model');
            $table->integer('category_id');
            $table->timestamps();
            $table->index(['tech', 'model']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('techs');
    }
}
