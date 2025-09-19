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
        'rol_externo',     // estudiante, docente, visitante, etc.
        'codigo_pc',
        'trae_vehiculo',
        'placa',
        'marca',
        'modelo',
        'color',
        'trae_pc',
        'serial_pc',
        'fecha_visita',
        'horario',
        'activo',          // 👈 importante para inactivar en vez de borrar
    ];

    protected $casts = [
        'trae_vehiculo' => 'boolean',
        'trae_pc'       => 'boolean',
        'activo'        => 'boolean',
        'fecha_visita'  => 'date',
    ];
}
