<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoTable extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_albums');
            $table->string('photo');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index(['photo']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
