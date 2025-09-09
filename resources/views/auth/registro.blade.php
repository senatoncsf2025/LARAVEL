@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <form class="login-form text-center bg-white p-4 shadow rounded w-100" method="POST" action="{{ route('registro.submit') }}">
        @csrf
        <h2>REGISTRO</h2>

        @if (session('success'))
            <div class="alert alert-success text-start">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Nombre -->
        <div class="mb-3 text-start">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <!-- Correo -->
        <div class="mb-3 text-start">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo') }}" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-3 text-start">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>

        <!-- Cédula -->
        <div class="mb-3 text-start">
            <label for="cedula" class="form-label">Cédula</label>
            <input type="text" name="cedula" id="cedula" class="form-control" value="{{ old('cedula') }}" required>
        </div>

        <!-- Dirección -->
        <div class="mb-3 text-start">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
        </div>

        <!-- Código Vigilante -->
        <div class="mb-3 text-start">
            <label for="codigo_vigilante" class="form-label">Código Vigilante</label>
            <input type="text" name="codigo_vigilante" id="codigo_vigilante" class="form-control" value="{{ old('codigo_vigilante') }}">
        </div>

        <!-- Contraseña -->
        <div class="mb-3 text-start">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" class="form-control" required>
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-3 text-start">
            <label for="contrasena_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="contrasena_confirmation" id="contrasena_confirmation" class="form-control" required>
        </div>

        <!-- Rol -->
        <div class="mb-3 text-start">
            <label for="rol" class="form-label">Selecciona un Rol</label>
            <select name="rol" id="rol" class="form-control" required>
                <option value="1" {{ old('rol') == 1 ? 'selected' : '' }}>Administrador</option>
                <option value="2" {{ old('rol') == 2 ? 'selected' : '' }}>Vigilante</option>
                <option value="3" {{ old('rol') == 3 ? 'selected' : '' }}>Visitante</option>
                <option value="4" {{ old('rol') == 4 ? 'selected' : '' }}>Usuario corriente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-dark w-100">Registrarse</button>

        <div class="extra mt-3">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a>
        </div>
    </form>
</div>
@endsection
