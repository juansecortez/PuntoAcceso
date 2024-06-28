<?php

use Illuminate\Database\Seeder;
use App\Models\UsoPuerta;
use App\Models\Empleado;
use App\Models\Puerta;

class UsoPuertaSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $empleadoId = Empleado::inRandomOrder()->first()->id;
            $puertaId = Puerta::inRandomOrder()->first()->id;

            UsoPuerta::create([
                'IdEmpleado' => $empleadoId,
                'IdPuerta' => $puertaId,
                'Fecha' => now()->subDays(rand(0, 10)),
                'latitude' => 19.4326 + rand(-100, 100) / 10000,
                'longitud' => -99.1332 + rand(-100, 100) / 10000
            ]);
        }
    }
}

