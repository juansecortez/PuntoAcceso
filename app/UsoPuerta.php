<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoPuerta extends Model
{
    use HasFactory;

    protected $table = 'uso_puerta';

    protected $fillable = [
        'IdEmpleado',
        'IdPuerta',
        'Fecha',
        'latitude',
        'longitud',
        'img',
    ];

    public function empleado()
{
    return $this->belongsTo(Empleado::class, 'IdEmpleado');
}

public function puerta()
{
    return $this->belongsTo(Puerta::class, 'IdPuerta');
}
}
