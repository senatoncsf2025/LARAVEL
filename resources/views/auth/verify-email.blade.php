@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <div class="card shadow p-4 w-100" style="max-width: 500px;">
        <h2 class="mb-3 text-center">Verifica tu correo electrónico</h2>

        @if (session('success'))
            <div class="alert alert-success text-start">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-start">
            Se envió un enlace de verificación al correo del usuario registrado.
            Pídele que revise su bandeja de entrada (y la carpeta de spam).
        </p>

        <p class="text-start mb-4">
            Si no recibió el correo, puedes reenviarlo:
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100">
                Reenviar correo de verificación
            </button>
        </form>

        {{-- ✅ Botón cancelar que lleva al dashboard --}}
        <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100 mt-3">
            Cancelar y volver al Dashboard
        </a>
    </div>
</div>
@endsection
