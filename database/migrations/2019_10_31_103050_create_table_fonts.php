<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFonts extends Migration
{
    public function up()
    {
        Schema::create('fonts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->index(['skk','name']);
        });
    }
    public function down()
    {
        Schema::dropIfExists('fonts');
    }
}
