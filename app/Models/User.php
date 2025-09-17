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

    // Laravel usa timestamps
    public $timestamps = true;

    // Campos asignables en masa
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'cedula',
        'direccion',
        'codigo_vigilante',
        'rol',
    ];

    // Campos ocultos al serializar
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting de atributos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Método de contraseña que usa Laravel Auth
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}
