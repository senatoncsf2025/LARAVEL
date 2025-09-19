<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'user_externo_id',
        'placa',
        'marca',
        'modelo',
        'color',
    ];

    public function usuario()
    {
        return $this->belongsTo(UserExterno::class, 'user_externo_id');
    }
}
