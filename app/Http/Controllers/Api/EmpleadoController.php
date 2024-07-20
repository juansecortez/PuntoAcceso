<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Empleado;
use App\Puerta;
use App\Organization;

class EmpleadoController extends Controller
{
    public function login(Request $request)
    {
        // Validar las entradas
        $request->validate([
            'telefono' => 'required',
            'curp' => 'required'
        ]);

        // Buscar el empleado por teléfono y CURP en la base de datos maestra
        $empleado = Empleado::where('Telefono', $request->telefono)
                            ->where('CURP', $request->curp)
                            ->first();

        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        // Obtener el banner desde el modelo Organization
        $organizationBanner = Organization::first()->banner;

        // Obtener las puertas asignadas al empleado desde la base de datos maestra
        $puertas = $empleado->puertas;

        // Formatear la respuesta
        $response = [
            'Datos' => [
                'usuario' => [
                    'id' => $empleado->id,
                    'nombre' => $empleado->Nombre . ' ' . $empleado->ApellidoP . ' ' . $empleado->ApellidoM,
                    'imgurl' => 'https://pactral.com/PuntoAcceso/public/' . $empleado->photo,
                    'bannerurl' => 'https://pactral.com/PuntoAcceso/public/' . $organizationBanner,
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
