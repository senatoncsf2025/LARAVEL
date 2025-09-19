<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserExternoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página principal pública (index = contacto)
Route::get('/', function () {
    return view('contacto');
})->name('home');

// Rutas de Contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// Otras páginas públicas
Route::view('/somos', 'somos')->name('somos');
Route::view('/mision', 'mision')->name('mision');
Route::view('/vision', 'vision')->name('vision');
Route::view('/soluciones', 'soluciones')->name('soluciones');
Route::view('/politica', 'politica')->name('politica');
Route::view('/terminos', 'terminos')->name('terminos');
Route::view('/faq', 'faq')->name('faq');

// Registro de visitantes (público)
Route::get('/registro', function () {
    return view('auth.registro'); // Vista registro.blade.php
})->name('registro');
Route::post('/registro', [UserExternoController::class, 'store'])->name('registro.submit');

// Login y logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (solo usuarios autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Panel principal (todos)
    Route::view('/index2', 'index2')->name('index2');

    // Ruta exclusiva para admin
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Registro de admin/vigilante (solo admin)
    Route::view('/registro_admin', 'auth.registro_admin')->name('registro_admin');

    /*
    |--------------------------------------------------------------------------
    | Secciones (para index2) → solo vistas
    |--------------------------------------------------------------------------
    */
    Route::view('/personal', 'secciones.personal')->name('personal');
    Route::view('/estudiantes', 'secciones.estudiantes')->name('estudiantes');
    Route::view('/docentes', 'secciones.docentes')->name('docentes');
    Route::view('/oficinas', 'secciones.oficinas')->name('oficinas');
    Route::view('/vigilantes', 'secciones.vigilantes')->name('vigilantes');
    Route::view('/enfermeria', 'secciones.enfermeria')->name('enfermeria');
    Route::view('/parqueadero', 'secciones.parqueadero')->name('parqueadero');
    Route::view('/visitantes', 'secciones.visitantes')->name('visitantes');
    Route::view('/acudientes', 'secciones.acudientes')->name('acudientes');

    /*
    |--------------------------------------------------------------------------
    | CRUD dinámico de cada módulo (dashboard)
    |--------------------------------------------------------------------------
    */
    $roles = [
        'estudiantes', 'docentes', 'personal',
        'oficinas', 'vigilantes', 'enfermeria',
        'parqueadero', 'visitantes', 'acudientes'
    ];

    foreach ($roles as $rol) {
        Route::prefix("dashboard/$rol")->group(function () use ($rol) {
            Route::get('/', [UserExternoController::class, 'index'])
                ->name("$rol.index")->defaults('rol', $rol);
            Route::get('/create', [UserExternoController::class, 'create'])
                ->name("$rol.create")->defaults('rol', $rol);
            Route::post('/', [UserExternoController::class, 'store'])
                ->name("$rol.store")->defaults('rol', $rol);
            Route::get('/{id}/edit', [UserExternoController::class, 'edit'])
                ->name("$rol.edit")->defaults('rol', $rol);
            Route::put('/{id}', [UserExternoController::class, 'update'])
                ->name("$rol.update")->defaults('rol', $rol);
            Route::delete('/{id}', [UserExternoController::class, 'destroy'])
                ->name("$rol.destroy")->defaults('rol', $rol);
        });
    }
});
