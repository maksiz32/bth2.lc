<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBirthdayTable extends Migration
{
    public function up()
    {
        Schema::create('birthdays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameF');
            $table->string('nameN');
            $table->string('nameOt');
            $table->string('dolzh');
            $table->string('work',500);
            $table->date('date');            
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->index(['nameF','nameN','nameOt','date']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('birthdays');
    }
}
