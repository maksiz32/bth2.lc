<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file');
            $table->string('name');
            $table->timestamps();
            $table->index(['file', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
