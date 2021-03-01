<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firm');
            $table->string('user_name')->nullable();
            $table->ipAddress('real_ip');
            $table->dateTime('created');
            $table->string('tech')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('count_m')->nullable();
            $table->string('others')->nullable();
            $table->timestamps();
            $table->index(['firm', 'model', 'others']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
