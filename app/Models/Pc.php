<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    use HasFactory;

    protected $table = 'pcs';

    protected $fillable = [
        'user_externo_id',
        'codigo_pc',
        'serial_pc',
    ];

    public function usuario()
    {
        return $this->belongsTo(UserExterno::class, 'user_externo_id');
    }
}
