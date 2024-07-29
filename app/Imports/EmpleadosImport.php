<?php
// app/Imports/EmpleadosImport.php

namespace App\Imports;

use App\Empleado;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class EmpleadosImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            $validator = Validator::make($data, [
                'nombre' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'curp' => 'required|string|max:255',
                'telefono' => 'required|numeric',
                'correo' => 'required|email|max:255',
              
            ]);

            if ($validator->fails()) {
                // Aquí puedes manejar el error de validación, como registrarlo o lanzarlo
                continue; // Salta este registro si no es válido
            }

            Empleado::create([
                'Nombre' => $row['nombre'],
                'ApellidoP' => $row['apellido_paterno'],
                'ApellidoM' => $row['apellido_materno'],
                'CURP' => $row['curp'],
                'Telefono' => $row['telefono'],
                'Correo' => $row['correo'],
                'NoContrato' =>  null,
                'photo' => null, // Asignar photo como null
            ]);
        }
    }
}
