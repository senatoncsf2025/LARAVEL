<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nombre real de la tabla
    protected $table = 'usuario';

    // Clave primaria real
    protected $primaryKey = 'ID_USUARIO';

    // Desactivar timestamps si la tabla no los tiene
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'nombre_usuario',
        'correo',
        'telefono',
        'cedula',
        'direccion',
        'codigo_vigilante',
        'contrasena_hash',
        'fk_id_rol',
    ];

    // Campos ocultos al serializar
    protected $hidden = [
        'contrasena_hash',
    ];

    // Casting de atributos si lo necesitas
    protected $casts = [
        // 'created_at' => 'datetime', // descomentar si existe
    ];
}
