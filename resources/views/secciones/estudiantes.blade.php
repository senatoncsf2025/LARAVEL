@extends('layouts.app')

@section('title', 'Consulta y Registro')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container py-5">
    <h2 class="text-center mb-4">Bienvenido</h2>

    <!-- Botones principales -->
    <div class="text-center mb-4">
        <button class="btn btn-primary mx-2" id="btnConsulta">Consulta / Entrada-Salida</button>
        <button class="btn btn-success mx-2" id="btnRegistro">Registro</button>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Formulario de Consulta / Entrada-Salida -->
    <div id="formConsulta" class="card p-4 shadow d-none">
        <h4 class="mb-3">Consulta y Registro de Entrada/Salida</h4>
        <form method="POST" action="{{ route('estudiantes.consulta') }}">
            @csrf
            <div class="mb-3">
                <label for="documento" class="form-label">Documento <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="documento" name="documento" required>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>

        @if(isset($usuario))
            <hr>
            <h5>Usuario: {{ $usuario->nombre }} {{ $usuario->apellido }}</h5>
            <form method="POST" action="{{ route('estudiantes.entradaSalida') }}">
                @csrf
                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                <button type="submit" name="tipo" value="entrada" class="btn btn-success">Registrar Entrada</button>
                <button type="submit" name="tipo" value="salida" class="btn btn-danger">Registrar Salida</button>
            </form>
        @endif
    </div>

    <!-- Formulario de Registro -->
    <div id="formRegistro" class="card p-4 shadow d-none mt-4">
        <h4 class="mb-3">Registro</h4>
        <form method="POST" action="{{ route('estudiantes.registro') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="telefono" name="telefono" pattern="\d{10}" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar Usuario</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnConsulta = document.getElementById('btnConsulta');
    const btnRegistro = document.getElementById('btnRegistro');
    const formConsulta = document.getElementById('formConsulta');
    const formRegistro = document.getElementById('formRegistro');

    btnConsulta.addEventListener('click', () => {
        formConsulta.classList.remove('d-none');
        formRegistro.classList.add('d-none');
    });
    btnRegistro.addEventListener('click', () => {
        formRegistro.classList.remove('d-none');
        formConsulta.classList.add('d-none');
    });
});
</script>
@endsection
