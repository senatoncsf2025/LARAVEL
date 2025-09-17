<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->nullable();
            $table->string('cedula')->nullable();
            $table->string('direccion')->nullable();
            $table->string('codigo_vigilante')->nullable();
            $table->tinyInteger('rol')->default(4); // Usuario corriente
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'cedula', 'direccion', 'codigo_vigilante', 'rol']);
        });
    }
};
