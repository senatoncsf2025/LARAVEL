<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserExternoController;
use App\Http\Controllers\VerificationController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página principal pública (index = contacto)
Route::get('/', function () {
    return view('contacto');
})->name('home');

// 📩 Rutas de Contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// 📄 Otras páginas públicas
Route::view('/somos', 'somos')->name('somos');
Route::view('/mision', 'mision')->name('mision');
Route::view('/vision', 'vision')->name('vision');
Route::view('/soluciones', 'soluciones')->name('soluciones');
Route::view('/politica', 'politica')->name('politica');
Route::view('/terminos', 'terminos')->name('terminos');
Route::view('/faq', 'faq')->name('faq');

/*
|--------------------------------------------------------------------------
| Registro público de visitantes
|--------------------------------------------------------------------------
*/
Route::get('/registro', function () {
    return view('registro');   // 👉 resources/views/registro.blade.php
})->name('registro');

Route::post('/registro', [UserExternoController::class, 'storeVisitante'])
    ->name('registro.submit');

/*
|--------------------------------------------------------------------------
| Login y recuperación de contraseña
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔑 Recuperación de contraseña
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.sms');
Route::get('/verify-code', [AuthController::class, 'showVerifyCodeForm'])->name('password.verify');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('password.verify.submit');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| RUTAS PARA VERIFICACIÓN DE EMAIL
|--------------------------------------------------------------------------
*/

// Aviso para verificar email
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

// Procesar link de verificación
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

// Reenviar correo de verificación
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (solo usuarios autenticados y verificados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Panel principal
    Route::view('/index2', 'index2')->name('index2');
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Registro de usuarios internos (admin o vigilante)
    Route::get('/registro_admin', [AuthController::class, 'showRegistroAdminForm'])->name('registro_admin');
    Route::post('/registro_admin', [AuthController::class, 'registroAdmin'])->name('registro_admin.submit');

    // Vistas de secciones
    Route::view('/personal', 'secciones.personal')->name('personal');
    Route::view('/estudiantes', 'secciones.estudiantes')->name('estudiantes');
    Route::view('/docentes', 'secciones.docentes')->name('docentes');
    Route::view('/oficinas', 'secciones.oficinas')->name('oficinas');
    Route::view('/vigilantes', 'secciones.vigilantes')->name('vigilantes');
    Route::view('/enfermeria', 'secciones.enfermeria')->name('enfermeria');
    Route::view('/parqueadero', 'secciones.parqueadero')->name('parqueadero');
    Route::view('/visitantes', 'secciones.visitantes')->name('visitantes');
    Route::view('/acudientes', 'secciones.acudientes')->name('acudientes');

    // CRUD dinámico
    $roles = [
        'estudiantes',
        'docentes',
        'personal',
        'oficinas',
        'vigilantes',
        'enfermeria',
        'parqueadero',
        'visitantes',
        'acudientes'
    ];

    foreach ($roles as $rol) {
        Route::prefix("dashboard/$rol")->group(function () use ($rol) {
            Route::get('/', [UserExternoController::class, 'index'])
                ->name("$rol.index")->defaults('rol', $rol);

            Route::get('/create', [UserExternoController::class, 'create'])
                ->name("$rol.create")->defaults('rol', $rol);

            Route::post('/', [UserExternoController::class, 'store'])
                ->name("$rol.store")->defaults('rol', $rol);

            // ⚡ Activar / Inactivar
            Route::put('/activar/{id}', [UserExternoController::class, 'activar'])
                ->name("$rol.activar")->defaults('rol', $rol);

            Route::put('/inactivar/{id}', [UserExternoController::class, 'inactivar'])
                ->name("$rol.inactivar")->defaults('rol', $rol);

            Route::get('/{id}/edit', [UserExternoController::class, 'edit'])
                ->name("$rol.edit")->defaults('rol', $rol);

            Route::put('/{id}', [UserExternoController::class, 'update'])
                ->name("$rol.update")->defaults('rol', $rol);

            Route::get('/reporte', [UserExternoController::class, 'reporte'])
                ->name("$rol.reporte")->defaults('rol', $rol);

            // 📌 Movimientos
            Route::post('/movimiento', [UserExternoController::class, 'registrarMovimiento'])
                ->name("$rol.movimiento")->defaults('rol', $rol);

            Route::get('/reporte-movimientos', [UserExternoController::class, 'reporteMovimientos'])
                ->name("$rol.reporteMovimientos")->defaults('rol', $rol);
                
        });
    }
});
