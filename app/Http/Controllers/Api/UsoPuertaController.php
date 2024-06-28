<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UsoPuerta; // Asegúrate de que la ruta sea correcta
use App\Puerta; // Asegúrate de que la ruta sea correcta
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UsoPuertaController extends Controller
{
    public function store(Request $request)
    {
        // Validar las entradas
        $request->validate([
            'IdEmpleado' => 'required|exists:empleados,id',
            'IdPuerta' => 'required|exists:puertas,id',
            'Fecha' => 'required|date',
            'latitude' => 'required|numeric',
            'longitud' => 'required|numeric',
            'img' => 'required|string', // Validar que img sea una cadena base64
        ]);

        // Convertir la imagen base64 a un archivo y guardarlo
        $image = $request->img;
        $image = str_replace('data:image/png;base64,', '', $image); // Remover el prefijo si existe
        $image = str_replace(' ', '+', $image);
        $imageName = uniqid() . '.png'; // Generar un nombre único para la imagen
        $imagePath = 'pictures/' . $imageName;
        Storage::disk('public')->put($imagePath, base64_decode($image));

        // Crear el nuevo registro en la tabla uso_puerta
        $usoPuerta = UsoPuerta::create([
            'IdEmpleado' => $request->IdEmpleado,
            'IdPuerta' => $request->IdPuerta,
            'Fecha' => $request->Fecha,
            'latitude' => $request->latitude,
            'longitud' => $request->longitud,
            'img' => $imagePath, // Guardar la ruta de la imagen
        ]);

        return response()->json(['success' => true, 'data' => $usoPuerta], 201);
    }

    public function filterPost(Request $request)
    {
        // Validar las entradas
        $request->validate([
            'IdEmpleado' => 'required|exists:empleados,id',
            'FechaInicio' => 'required|date',
            'FechaFin' => 'required|date',
        ]);
    
        // Ajustar las fechas para cubrir todo el día
        $fechaInicio = Carbon::parse($request->FechaInicio)->startOfDay(); // 00:00:00
        $fechaFin = Carbon::parse($request->FechaFin)->endOfDay(); // 23:59:59
    
        // Obtener los registros de uso_puerta filtrados
        $usoPuertas = UsoPuerta::where('IdEmpleado', $request->IdEmpleado)
            ->whereBetween('Fecha', [$fechaInicio, $fechaFin])
            ->get();
    
        // Construir la respuesta
        $response = $usoPuertas->map(function ($usoPuerta) {
            $puerta = Puerta::find($usoPuerta->IdPuerta);
            return [
                'IdPuerta' => $usoPuerta->IdPuerta,
                'NombrePuerta' => $puerta->NombrePuerta,
                'latitude' => $usoPuerta->latitude,
                'longitud' => $usoPuerta->longitud,
                'Tipo' => $puerta->Tipo,
                'img' => 'https://pactral.com/PuntoAcceso/public/'.$usoPuerta->img,
                'Fecha' => $usoPuerta->Fecha,
            ];
        });
    
        return response()->json(['success' => true, 'data' => $response], 200);
    }
    
}
