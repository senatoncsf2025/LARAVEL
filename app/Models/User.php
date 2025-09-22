<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nombre de la tabla
    protected $table = 'users';

    // Clave primaria
    protected $primaryKey = 'id';

    // Laravel maneja timestamps
    public $timestamps = true;

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'cedula',
        'direccion',
        'genero',
        'fecha_nacimiento',
        'codigo_verificacion',
        'telefono_verificado',
        'rol',
        'codigo_vigilante',
        'cargo',
        'activo',
    ];

    /**
     * Campos ocultos al serializar
     */
    protected $hidden = [
        'password',
        'remember_token',
        'codigo_verificacion', // No exponer nunca este campo
    ];

    /**
     * Casting de atributos
     */
    protected $casts = [
        'email_verified_at'   => 'datetime',
        'fecha_nacimiento'    => 'date',
        'telefono_verificado' => 'boolean',
        'activo'              => 'boolean',
    ];

    /**
     * Método de contraseña que usa Laravel Auth
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}
