<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Empleado;
use App\Puerta;

class EmpleadoController extends Controller
{
    public function login(Request $request)
    {
        // Validar las entradas
        $request->validate([
            'telefono' => 'required',
            'curp' => 'required'
        ]);

        // Buscar el empleado por teléfono y CURP
        $empleado = Empleado::where('Telefono', $request->telefono)
                            ->where('CURP', $request->curp)
                            ->first();

        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        // Obtener las puertas asignadas al empleado
        $puertas = $empleado->puertas;

        // Formatear la respuesta
        $response = [
            'Datos' => [
                'usuario' => [
                    'id' => $empleado->id,
                  'nombre' => $empleado->Nombre . ' ' . $empleado->ApellidoP . ' ' . $empleado->ApellidoM,

                    'imgurl' => 'https://pactral.com/PuntoAcceso/public/' .$empleado->photo,
                    'bannerurl' => 'https://www.antevenio.com/wp-content/uploads/2016/04/20-ejemplos-de-banners-creativos.jpg'
                ]
            ],
            'puertas' => $puertas->map(function ($puerta) {
                return [
                    'idpuerta' => $puerta->id,
                    'puerta' => $puerta->NombrePuerta,
                    'tipo' => $puerta->Tipo,
                    'lat' => $puerta->latitude,
                    'lon' => $puerta->longitud,
                ];
            }),
        ];

        return response()->json($response);
    }
}
