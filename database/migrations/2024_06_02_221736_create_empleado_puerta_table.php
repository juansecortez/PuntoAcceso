<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoPuertaTable extends Migration
{
    public function up()
    {
        Schema::create('empleado_puerta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdEmpleado');
            $table->unsignedBigInteger('IdPuerta');
            $table->foreign('IdEmpleado')->references('id')->on('empleados');
            $table->foreign('IdPuerta')->references('id')->on('puertas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleado_puerta');
    }
}
