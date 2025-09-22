@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <form class="login-form text-center bg-white p-4 shadow rounded w-100" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <h2>INICIO SESIÓN</h2>

        @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success text-start">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 text-start">
            <label for="email" class="form-label">Correo</label>
            <input type="email" name="email" id="email" class="form-control" 
                placeholder="Ingresa tu correo" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3 text-start position-relative">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" 
                    placeholder="Ingresa tu contraseña" required>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                    👁️
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-dark w-100">Ingresar</button>

        <div class="extra mt-3">
            ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a><br>
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
</div>

{{-- Script para mostrar/ocultar contraseña --}}
@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Cambiar el icono
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>
@endpush
@endsection
