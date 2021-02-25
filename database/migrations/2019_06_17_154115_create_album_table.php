<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTable extends Migration
{
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('show');
            $table->timestamps();
            $table->index(['path','name']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
