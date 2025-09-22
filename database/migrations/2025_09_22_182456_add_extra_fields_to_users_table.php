<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cedula')->nullable()->unique()->after('id');
            $table->string('direccion')->nullable()->after('cedula');
            $table->string('telefono', 20)->nullable()->after('direccion');
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro'])->nullable()->after('telefono');
            $table->date('fecha_nacimiento')->nullable()->after('genero');

            // Solo para vigilantes
            $table->string('codigo_vigilante')->nullable()->after('fecha_nacimiento');
            $table->string('cargo')->nullable()->after('codigo_vigilante');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'cedula',
                'direccion',
                'telefono',
                'genero',
                'fecha_nacimiento',
                'codigo_vigilante',
                'cargo'
            ]);
        });
    }
};
