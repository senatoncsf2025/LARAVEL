<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AuthController;

// Ruta Home → contacto.blade.php
Route::get('/', [ContactoController::class, 'index'])->name('home');

// Rutas de Contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// Otras rutas del navbar
Route::view('/somos', 'somos')->name('somos');
Route::view('/mision', 'mision')->name('mision');
Route::view('/vision', 'vision')->name('vision');
Route::view('/soluciones', 'soluciones')->name('soluciones');
Route::view('/politica', 'politica')->name('politica');
Route::view('/terminos', 'terminos')->name('terminos');
Route::view('/faq', 'faq')->name('faq');

// Rutas de Login y Registro
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de Registro
Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('registro');
Route::post('/registro', [AuthController::class, 'register'])->name('registro.submit');

// Ejemplo de ruta protegida (solo usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
