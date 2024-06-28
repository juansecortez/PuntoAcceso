<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCodepuertaToNombrepuertaInPuertasTable extends Migration
{
    public function up()
    {
        Schema::table('puertas', function (Blueprint $table) {
            $table->renameColumn('CodePuerta', 'NombrePuerta');
        });
    }

    public function down()
    {
        Schema::table('puertas', function (Blueprint $table) {
            $table->renameColumn('NombrePuerta', 'CodePuerta');
        });
    }
}
