<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('ApellidoM');
            $table->string('ApellidoP');
            $table->string('CURP')->unique();
            $table->double('Telefono');
            $table->string('Correo')->unique();
            $table->integer('NoContrato');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
