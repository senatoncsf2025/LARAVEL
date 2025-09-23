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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre completo
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Datos adicionales
            $table->string('telefono', 20)->nullable();
            $table->string('codigo_verificacion')->nullable();
            $table->boolean('telefono_verificado')->default(false);

            // Roles: 1=Administrador, 2=Vigilante
            $table->tinyInteger('rol')->default(2);

            // Info personal
            $table->string('cedula')->nullable()->unique();
            $table->string('direccion')->nullable();
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->date('fecha_nacimiento')->nullable();

            // Solo para vigilantes
            $table->string('codigo_vigilante')->nullable();
            $table->string('cargo')->nullable();

            // Estado del usuario (activo/inactivo)
            $table->boolean('activo')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });

        // Tabla para tokens de recuperación
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabla de sesiones
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
