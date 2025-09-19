@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center flex-column py-5">
    <form class="login-form text-center bg-white p-4 shadow rounded w-100" 
          method="POST" 
          action="{{ route('registro.submit') }}">
        @csrf
        <h2>REGISTRO DE VISITA</h2>

        @if (session('success'))
            <div class="alert alert-success text-start">{{ session('success') }}</div>
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

        <!-- Rol fijo -->
        <input type="hidden" name="rol_externo" value="visitante">

        <!-- DATOS DEL VISITANTE -->
        <div class="mb-3 text-start">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3 text-start">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="{{ old('email') }}">
        </div>

        <div class="mb-3 text-start">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" 
                   value="{{ old('telefono') }}">
        </div>

        <div class="mb-3 text-start">
            <label for="cedula" class="form-label">Cédula</label>
            <input type="text" name="cedula" id="cedula" class="form-control" 
                   value="{{ old('cedula') }}">
        </div>

        <!-- TRAE VEHÍCULO -->
        <div class="mb-3 text-start">
            <label class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="traeVehiculo" class="form-control">
                <option value="0" {{ old('trae_vehiculo') == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo') == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <!-- FORMULARIO VEHÍCULO -->
        <div id="formVehiculo" style="display: none;">
            <h5 class="text-success mt-4 mb-3">Datos del vehículo</h5>
            <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" name="placa" id="placa" class="form-control" value="{{ old('placa') }}">
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" name="marca" id="marca" class="form-control" value="{{ old('marca') }}">
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo') }}">
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}">
            </div>
        </div>

        <!-- PC -->
        <div class="mb-3 text-start">
            <label class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="traePC" class="form-control">
                <option value="0" {{ old('trae_pc') == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc') == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <div id="formPC" style="display: none;">
            <div class="mb-3 text-start">
                <label for="serial_pc" class="form-label">Últimos 4 dígitos del serial del PC</label>
                <input type="text" name="serial_pc" id="serial_pc" class="form-control" maxlength="4" 
                       value="{{ old('serial_pc') }}">
            </div>
        </div>

        <!-- DÍA Y HORARIO -->
        <div class="mb-3 text-start">
            <label for="fecha_visita" class="form-label">Día de visita</label>
            <input type="date" name="fecha_visita" id="fecha_visita" class="form-control" 
                   value="{{ old('fecha_visita') }}">
        </div>

        <div class="mb-3 text-start">
            <label for="horario" class="form-label">Horario</label>
            <select name="horario" id="horario" class="form-control" required>
                <option value="AM">00:00 AM - 12:00 PM</option>
                <option value="PM">12:01 PM - 11:59 PM</option>
            </select>
        </div>

        <button type="submit" class="btn btn-dark w-100">Registrar Visita</button>
    </form>
</div>

<script>
document.getElementById('traeVehiculo').addEventListener('change', function() {
    document.getElementById('formVehiculo').style.display = this.value == '1' ? 'block' : 'none';
});

document.getElementById('traePC').addEventListener('change', function() {
    document.getElementById('formPC').style.display = this.value == '1' ? 'block' : 'none';
});

// Mantener visibilidad si hubo errores
window.addEventListener('load', function() {
    if(document.getElementById('traeVehiculo').value == '1') {
        document.getElementById('formVehiculo').style.display = 'block';
    }
    if(document.getElementById('traePC').value == '1') {
        document.getElementById('formPC').style.display = 'block';
    }
});
</script>
@endsection
