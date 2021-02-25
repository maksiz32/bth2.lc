<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_avto');
            $table->string('who',30);
            $table->string('target');
            $table->integer('ip')->length(10);
            $table->string('phone',10);
            $table->date('date');
            $table->integer('time_start');
            $table->integer('count_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
