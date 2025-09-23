@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <form class="login-form text-center bg-white p-4 shadow rounded w-100" method="POST"
        action="{{ route('registro_admin.submit') }}">
        @csrf
        <h2>REGISTRO DE USUARIO</h2>

        {{-- ✅ Mensajes de éxito --}}
        @if (session('success'))
        <div class="alert alert-success text-start">{{ session('success') }}</div>
        @endif

        {{-- ✅ Errores de validación --}}
        @if ($errors->any())
        <div class="alert alert-danger text-start">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- DATOS BÁSICOS -->
        <div class="mb-3 text-start">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror" required>
        </div>

        <div class="mb-3 text-start">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                required>
        </div>

        <!-- 🔹 Checkbox para mostrar/ocultar contraseña -->
        <div class="form-check mb-3 text-start">
            <input class="form-check-input" type="checkbox" id="togglePassword">
            <label class="form-check-label" for="togglePassword">
                Mostrar contraseñas
            </label>
        </div>

        <div class="mb-3 text-start">
            <label for="cedula" class="form-label">Cédula</label>
            <input type="text" name="cedula" id="cedula" class="form-control @error('cedula') is-invalid @enderror"
                value="{{ old('cedula') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion"
                class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono"
                class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="genero" class="form-label">Género</label>
            <select name="genero" id="genero" class="form-control @error('genero') is-invalid @enderror" required>
                <option value="">-- Selecciona --</option>
                <option value="Masculino" {{ old('genero')=='Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero')=='Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero')=='Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>

        <div class="mb-3 text-start">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                value="{{ old('fecha_nacimiento') }}" required>
        </div>

        <!-- ROL -->
        <div class="mb-3 text-start">
            <label for="rol" class="form-label">Selecciona un Rol</label>
            <select name="rol" id="rol" class="form-control @error('rol') is-invalid @enderror" required>
                <option value="">-- Selecciona --</option>
                <option value="1" {{ old('rol')==1 ? 'selected' : '' }}>Administrador</option>
                <option value="2" {{ old('rol')==2 ? 'selected' : '' }}>Vigilante</option>
            </select>
        </div>

        <!-- CAMPOS VIGILANTE -->
        <div id="camposVigilante" style="display: none;">
            <div class="mb-3 text-start">
                <label for="codigo_vigilante" class="form-label">Código Vigilante</label>
                <input type="text" name="codigo_vigilante" id="codigo_vigilante"
                    class="form-control @error('codigo_vigilante') is-invalid @enderror"
                    value="{{ old('codigo_vigilante') }}">
            </div>
            <div class="mb-3 text-start">
                <label for="cargo" class="form-label">Cargo</label>
                <select name="cargo" id="cargo" class="form-control @error('cargo') is-invalid @enderror">
                    <option value="">-- Selecciona Cargo --</option>
                    <option value="Supervisor" {{ old('cargo')=='Supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="Portero" {{ old('cargo')=='Portero' ? 'selected' : '' }}>Portero</option>
                    <option value="Otro" {{ old('cargo')=='Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-dark w-100">Registrar Usuario</button>
    </form>
</div>

<script>
    document.getElementById('rol').addEventListener('change', function () {
        document.getElementById('camposVigilante').style.display = this.value == '2' ? 'block' : 'none';
    });

    // Mantener visibilidad si hubo errores
    window.addEventListener('load', function () {
        if (document.getElementById('rol').value == '2') {
            document.getElementById('camposVigilante').style.display = 'block';
        }
    });

    // 🔹 Mostrar/ocultar contraseñas
    document.getElementById('togglePassword').addEventListener('change', function () {
        let password = document.getElementById('password');
        let confirm = document.getElementById('password_confirmation');
        if (this.checked) {
            password.type = 'text';
            confirm.type = 'text';
        } else {
            password.type = 'password';
            confirm.type = 'password';
        }
    });
</script>
@endsection