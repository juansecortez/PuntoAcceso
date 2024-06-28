<?php

use Illuminate\Database\Seeder;
use App\Models\EmpleadoPuerta;
use App\Models\Empleado;
use App\Models\Puerta;

class EmpleadoPuertaSeeder extends Seeder
{
    public function run()
    {
        $empleadoId = Empleado::inRandomOrder()->first()->id;
        $puertaId = Puerta::inRandomOrder()->first()->id;

        EmpleadoPuerta::create([
            'IdEmpleado' => $empleadoId,
            'IdPuerta' => $puertaId
        ]);

        // Repite o usa un bucle para crear más asociaciones
    }
}
