@extends('layouts.app')

@section('title', 'Panel Principal - SIORTISOFT')

@section('content')
<div style="padding-top: 120px;"></div>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<main class="container my-4">
    <h1 class="text-center mb-4">Panel Principal</h1>

    {{-- Sección Usuarios --}}
    <h2 class="text-center mb-4">Usuarios</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('personal.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Personal</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('estudiantes.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Estudiantes</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('docentes.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Docentes</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Sección Administrativos --}}
    <h2 class="text-center my-4">Administrativos</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('oficinas.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Oficinas</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('vigilantes.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Vigilantes</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('enfermeria.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Enfermería</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Sección Servicios --}}
    <h2 class="text-center my-4">Servicios</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('parqueadero.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Parqueadero</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('visitantes.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Visitantes</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('acudientes.index') }}">
                <div class="card dashboard-card text-center clickable">
                    <div class="card-body">
                        <h5 class="card-title">Acudientes</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
