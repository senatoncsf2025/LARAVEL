<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_externo_id')
                  ->constrained('users_externos')
                  ->onDelete('cascade');
            
            // 🔹 Datos del movimiento
            $table->string('nombre');   // Guardar nombre del usuario en el movimiento
            $table->string('cedula');   // Guardar cédula del usuario en el movimiento
            $table->enum('tipo', ['ingreso', 'salida']);
            $table->timestamp('fecha_hora');
            $table->string('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
