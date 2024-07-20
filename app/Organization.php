<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $fillable = [
        'name', 'banner'
    ];

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'organization_id');
    }
    public function resolveRouteBinding($value, $field = null)
    {
        $query = $this->on('organization')->where($field ?? $this->getRouteKeyName(), $value);
        $result = $query->first();
        \Log::info("Intentando resolver enlace de ruta para Empleado con valor: {$value}");
        if (!$result) {
            \Log::error("Empleado no encontrado en la base de datos de la organización");
        }
        return $result;
    }
}

