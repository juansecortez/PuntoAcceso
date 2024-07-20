<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UsoPuerta; // Asegúrate de que la ruta sea correcta
use App\Puerta; // Asegúrate de que la ruta sea correcta
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class UsoPuertaController extends Controller
{
    public function store(Request $request)
    {
        // Intenta ejecutar la inserción dentro de una transacción para manejar errores más fácilmente
        DB::beginTransaction();

        try {
            // Validar las entradas
            $validatedData = $request->validate([
                'IdEmpleado' => 'required|exists:empleados,id',
                'IdPuerta' => 'required|exists:puertas,id',
                'Fecha' => 'required|date',
                'latitude' => 'required|numeric',
                'longitud' => 'required|numeric',
                'img' => 'required|string', // Asegúrate que img sea una cadena base64
            ]);

            // Convertir la imagen base64 a un archivo y guardarla
            $image = $request->img;
            $image = str_replace('data:image/png;base64,', '', $image); // Remover el prefijo si existe
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.png'; // Generar un nombre único para la imagen
            $imagePath = 'pictures/' . $imageName;
            Storage::disk('public')->put($imagePath, base64_decode($image));

            // Crear el nuevo registro en la tabla uso_puerta
            $usoPuerta = UsoPuerta::create([
                'IdEmpleado' => $validatedData['IdEmpleado'],
                'IdPuerta' => $validatedData['IdPuerta'],
                'Fecha' => $validatedData['Fecha'],
                'latitude' => $validatedData['latitude'],
                'longitud' => $validatedData['longitud'],
                'img' => $imagePath, // Guardar la ruta de la imagen
            ]);

            DB::commit(); // Confirmar la transacción

            return response()->json(['success' => true, 'data' => $usoPuerta], 201);

        } catch (Exception $e) {
            DB::rollBack(); // Revertir todos los cambios en la base de datos
            Log::error('Error al crear el uso de puerta: ' . $e->getMessage());

            // Devuelve un mensaje de error general
            return response()->json(['success' => false, 'message' => 'Error al registrar el uso de la puerta'], 500);
        }
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
