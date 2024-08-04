<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    
    protected $table = 'empleados';

    protected $fillable = [
        'Nombre',
        'ApellidoP',
        'ApellidoM',
        'CURP',
        'Telefono',
        'Correo',
        'NoContrato',
        'photo',
        'FechaInicioContrato',
        'FechaNacimiento',
        'activo', 
        'fecha_baja', 
         'organizacion_id'
    ];

    public function profilePicture()
    {
        if ($this->photo) {
            return "/{$this->photo}";
        }

        return 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg';
    }
    
    public function puertas()
    {
        return $this->belongsToMany(Puerta::class, 'empleado_puerta', 'IdEmpleado', 'IdPuerta')
                    ->withTimestamps();
    }

    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'NoContrato', 'NoContrato');
    }

    public function usoPuertas()
    {
        return $this->hasMany(UsoPuerta::class, 'IdEmpleado');
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizacion_id');
    }
}