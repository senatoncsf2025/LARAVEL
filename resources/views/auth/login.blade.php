@extends('layouts.app')

@section('content')
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
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control" 
                placeholder="Ingresa tu correo" value="{{ old('correo') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" class="form-control" 
                placeholder="Ingresa tu contraseña" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Ingresar</button>

        <div class="extra mt-3">
            ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a><br>
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
</div>
@endsection
