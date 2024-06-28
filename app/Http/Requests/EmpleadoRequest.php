<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'Nombre' => 'required|string|max:255',
            'ApellidoP' => 'required|string|max:255',
            'ApellidoM' => 'required|string|max:255',
            'CURP' => 'required|string|max:255',
            'Telefono' => 'required|numeric',
            'Correo' => 'required|email|max:255',
            'NoContrato' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
