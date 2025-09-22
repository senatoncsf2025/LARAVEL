<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_externo_id',
        'nombre',
        'cedula',
        'tipo',
        'fecha_hora',
        'observaciones',
    ];


    public function usuario()
    {
        return $this->belongsTo(UserExterno::class, 'user_externo_id');
    }
}
