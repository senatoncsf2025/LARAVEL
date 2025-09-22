@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <form class="login-form text-center bg-white p-4 shadow rounded w-100" 
          method="POST" action="{{ route('password.update') }}">
        @csrf
        <h2>Restablecer Contraseña</h2>

        @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <input type="password" name="password" id="password" class="form-control"
                   placeholder="Escribe tu nueva contraseña" required>
        </div>

        <div class="mb-3 text-start">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control" placeholder="Repite tu nueva contraseña" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Restablecer</button>

        <div class="extra mt-3">
            <a href="{{ route('login') }}">Volver al login</a>
        </div>
    </form>
</div>
@endsection
