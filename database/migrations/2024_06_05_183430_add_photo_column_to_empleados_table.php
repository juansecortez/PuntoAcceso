<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoColumnToEmpleadosTable extends Migration
{
    public function up()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('id'); // Cambia 'password' por la columna adecuada
        });
    }

    public function down()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}
