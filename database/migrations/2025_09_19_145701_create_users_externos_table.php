<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_externos', function (Blueprint $table) {
            $table->id();

            // Datos básicos
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('cedula')->nullable()->unique(); // Documento único si se proporciona
            $table->string('telefono', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();

            // Datos adicionales para visitantes
            $table->date('fecha_visita')->nullable();
            $table->enum('horario', ['AM', 'PM'])->nullable(); // AM o PM, consistente con el formulario

            // Clasificación por rol externo (ej: estudiante, docente, visitante…)
            $table->string('rol_externo'); 

            // Estado
            $table->boolean('activo')->default(true);

            // Quién lo registró (admin o vigilante)
            $table->foreignId('registrado_por')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_externos');
    }
};
