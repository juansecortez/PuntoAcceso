<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $fillable = [
        'name', 'banner'
    ];

    // Relación con usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'organizacion_id');
    }

    // Relación con empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'organizacion_id');
    }

    // Relación con contratos
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'organizacion_id');
    }

    // Relación con puertas
    public function puertas()
    {
        return $this->hasMany(Puerta::class, 'organizacion_id');
    }

    // Relación con uso de puertas
    public function usoPuertas()
    {
        return $this->hasMany(UsoPuerta::class, 'organizacion_id');
    }
}

