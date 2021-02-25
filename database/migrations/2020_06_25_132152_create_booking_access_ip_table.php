<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingAccessIpTable extends Migration
{
    public function up()
    {
        Schema::create('access_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_firms');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('access_ips');
    }
}
