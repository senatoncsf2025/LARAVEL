@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<section id="inicio" class="hero-section text-center position-relative">

    <!-- Overlay -->
    <div class="hero-overlay"></div>

    <div class="container position-relative">
        <h1 class="display-3 fw-bold mb-4">BIENVENIDOS A SIORTISOFT</h1>
        <p class="lead mb-5">
            Soluciones innovadoras y seguras para colegios, universidades y entidades gubernamentales.
        </p>
        <a href="{{ route('soluciones') }}" class="btn btn-fondo btn-lg me-2">
            Descubre Nuestras Soluciones
        </a>
       <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-fondo btn-lg">
    Contáctanos
</a>

    </div>
</section>


<!-- Formulario de Contacto -->
<div class="container py-5">
    <h2 class="text-center mb-5 display-4 fw-bold text-dark">Hablemos de tu Institución</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contacto.store') }}" method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre del Contacto</label>
                <input type="text" id="nombre" name="nombre" class="form-control" 
                       value="{{ old('nombre') }}" required>
            </div>
            <div class="col-md-6">
                <label for="institucion" class="form-label">Institución / Entidad</label>
                <input type="text" id="institucion" name="institucion" class="form-control" 
                       value="{{ old('institucion') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico Oficial</label>
            <input type="email" id="email" name="email" class="form-control" 
                   value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Número de Teléfono</label>
            <input type="tel" id="telefono" name="telefono" class="form-control" 
                   value="{{ old('telefono') }}" required>
        </div>
        <div class="mb-3">
            <label for="mensaje" class="form-label">¿Cómo podemos ayudarte?</label>
            <textarea id="mensaje" name="mensaje" class="form-control" rows="5" required>{{ old('mensaje') }}</textarea>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-dark btn-lg">Enviar Solicitud</button>
        </div>
    </form>
</div>
@endsection
