<?php

use Illuminate\Database\Seeder;
use App\Models\Puerta;

class PuertaSeeder extends Seeder
{
    public function run()
    {
        Puerta::create([
            'CodePuerta' => 101,
            'latitude' => 19.4326,
            'longitud' => -99.1332,
            'Tipo' => 'Entrada Principal'
        ]);

        Puerta::create([
            'CodePuerta' => 102,
            'latitude' => 19.4340,
            'longitud' => -99.1310,
            'Tipo' => 'Salida Secundaria'
        ]);
        // Añade más puertas según necesites
    }
}
