<?php

use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        Empleado::create([
            'Nombre' => 'Juan',
            'ApellidoM' => 'Pérez',
            'ApellidoP' => 'López',
            'CURP' => 'CURP001',
            'Telefono' => 5512345678,
            'Correo' => 'juan.perez@example.com',
            'NoContrato' => 1234
        ]);
        // Agrega más empleados como necesites o usa Faker para generar datos aleatorios
    }
}
