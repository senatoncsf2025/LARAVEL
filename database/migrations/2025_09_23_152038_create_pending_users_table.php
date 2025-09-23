<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pending_users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('rol'); // 1=Admin, 2=Vigilante

            $table->string('cedula')->unique();
            $table->string('telefono', 20);
            $table->string('direccion');
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']);
            $table->date('fecha_nacimiento');

            // Solo si es vigilante
            $table->string('codigo_vigilante')->nullable();
            $table->string('cargo')->nullable();

            // Token de verificación
            $table->string('token', 128)->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_users');
    }
};
