<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuertasTable extends Migration
{
    public function up()
    {
        Schema::create('puertas', function (Blueprint $table) {
            $table->id();
            $table->integer('CodePuerta');
            $table->double('latitude');
            $table->double('longitud');
            $table->string('Tipo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('puertas');
    }
}
