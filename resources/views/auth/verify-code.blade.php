@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <form class="login-form text-center bg-white p-4 shadow rounded w-100" 
          method="POST" action="{{ route('password.verify.submit') }}">
        @csrf
        <h2>Verificar Código</h2>

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
            <label for="code" class="form-label">Código de verificación</label>
            <input type="text" name="code" id="code" class="form-control"
                   placeholder="Ingresa el código recibido por SMS" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Validar Código</button>

        <div class="extra mt-3">
            <a href="{{ route('password.request') }}">Solicitar nuevo código</a>
        </div>
    </form>
</div>
@endsection
