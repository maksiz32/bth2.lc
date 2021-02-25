<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmTable extends Migration
{
    public function up()
    {
        Schema::create('firms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nameEng');
            $table->unsignedTinyInteger('isblock');
            $table->string('nameNSO');
            $table->string('famNSO');
            $table->string('otchNSO');
            $table->ipAddress('ipStart');
            $table->ipAddress('ipEnd');
            $table->string('addr');
            $table->string('tel')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index(['name', 'nameNSO', 'famNSO']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('firms');
    }
}
