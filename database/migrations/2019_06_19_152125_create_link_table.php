<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTable extends Migration
{
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->string('name');
            $table->timestamps();
            $table->index(['path', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
}
