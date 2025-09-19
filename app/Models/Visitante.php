<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'cedula',
        'trae_vehiculo',
        'placa',
        'marca',
        'modelo',
        'color',
        'trae_pc',
        'serial_pc',
        'fecha_visita',
        'horario',
    ];
}
