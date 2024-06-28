<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puerta extends Model
{
    use HasFactory;

    // Especificar la tabla asociada con el modelo
    protected $table = 'puertas';

    // Especificar los campos que se pueden asignar masivamente
    protected $fillable = [
        'NombrePuerta',
        'latitude',
        'longitud',
        'Tipo',
    ];


    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_puerta', 'IdPuerta', 'IdEmpleado')
                    ->withTimestamps();
    }
    public function usoPuertas()
    {
        return $this->hasMany(UsoPuerta::class, 'IdPuerta');
    }
    
}
