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
Route::get('/somos', function () { return view('somos'); })->name('somos');
Route::get('/mision', function () { return view('mision'); })->name('mision');
Route::get('/vision', function () { return view('vision'); })->name('vision');
Route::get('/soluciones', function () { return view('soluciones'); })->name('soluciones');
Route::get('/politica', function () { return view('politica'); })->name('politica');
Route::get('/terminos', function () { return view('terminos'); })->name('terminos');
Route::get('/faq', function () { return view('faq'); })->name('faq');

// Rutas de Login y Registro
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('registro');
Route::post('/registro', [AuthController::class, 'register'])->name('registro.submit');
