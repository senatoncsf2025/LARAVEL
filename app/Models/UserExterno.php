<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExterno extends Model
{
    use HasFactory;

    protected $table = 'users_externos';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'direccion',
        'email',
        'rol_externo',   // estudiante, docente, visitante, etc.
        'fecha_visita',
        'horario',
        'activo',        // inactivar en vez de borrar
    ];

    protected $casts = [
        'activo'       => 'boolean',
        'fecha_visita' => 'date',
    ];

    // Relaciones
    public function vehiculo()
    {
        return $this->hasOne(Vehiculo::class, 'user_externo_id');
    }

    public function pc()
    {
        return $this->hasOne(Pc::class, 'user_externo_id');
    }
}
