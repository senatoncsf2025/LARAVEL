<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    use HasFactory;

    protected $table = 'pending_users';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'cedula',
        'telefono',
        'direccion',
        'genero',
        'fecha_nacimiento',
        'codigo_vigilante',
        'cargo',
        'token',
    ];

    public $timestamps = true;
}
