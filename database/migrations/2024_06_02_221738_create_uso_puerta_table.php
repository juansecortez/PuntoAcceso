<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoPuertaTable extends Migration
{
    public function up()
    {
        Schema::create('uso_puerta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdEmpleado');
            $table->unsignedBigInteger('IdPuerta');
            $table->datetime('Fecha');
            $table->double('latitude');
            $table->double('longitud');
            $table->foreign('IdEmpleado')->references('id')->on('empleados');
            $table->foreign('IdPuerta')->references('id')->on('puertas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('uso_puerta');
    }
}
