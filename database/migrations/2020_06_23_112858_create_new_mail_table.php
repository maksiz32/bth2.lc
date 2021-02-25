<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewMailTable extends Migration
{
    public function up()
    {
        Schema::create('new_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('who');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('new_mails');
    }
}
