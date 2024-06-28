<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    
    protected $table = 'contratos';

    protected $fillable = [
        'NombreContrato',
        'NoContrato',
        'EncargadoInterno',
        'EncargadoExterno',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'NoContrato', 'NoContrato');
    }
}
