<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoEstudiante extends Model
{
    use HasFactory;

    protected $table = 'ingresos_estudiantes'; // Nombre exacto de tu tabla

    protected $fillable = [
        'usuario_id',
        'tipo', // 'entrada' o 'salida'
        'fecha_hora',
    ];

    public $timestamps = false; // si no vas a usar created_at y updated_at

    // Relación inversa
    public function usuario()
    {
        return $this->belongsTo(UsuarioEstudiante::class, 'usuario_id');
    }
}
