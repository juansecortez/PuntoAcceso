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
        'organizacion_id'
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'NoContrato', 'NoContrato');
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizacion_id');
    }
}
