<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'NombreContrato' => 'required|string|max:255',
            'NoContrato' => 'required|string|max:255|unique:contratos,NoContrato,' . $this->contrato,
            'EncargadoInterno' => 'required|string|max:255',
            'EncargadoExterno' => 'required|string|max:255',
        ];
    }
}
