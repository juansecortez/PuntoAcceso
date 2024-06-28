<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoPuerta extends Model
{
    use HasFactory;
    protected $table = 'empleado_puerta';

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'IdEmpleado');
    }

    public function puerta()
    {
        return $this->belongsTo(Puerta::class, 'IdPuerta');
    }
}
