<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    use HasFactory;

    protected $table = 'pcs';

    protected $fillable = [
        'serial',
        'activo',
        'user_id',
        'user_externo_id',
    ];

    // 🔗 Relación inversa con usuario externo
    public function usuarioExterno()
    {
        return $this->belongsTo(UserExterno::class, 'user_externo_id');
    }

    // 🔗 Relación opcional con usuario interno
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
