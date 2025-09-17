<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEstudiante extends Model
{
    use HasFactory;

    protected $table = 'usuarios__estudiantes'; // Nombre exacto de tu tabla

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'codigo_portatil',
        'telefono',
        'direccion',
    ];

    // Relación con los ingresos
    public function ingresos()
    {
        return $this->hasMany(IngresoEstudiante::class, 'usuario_id');
    }
}
