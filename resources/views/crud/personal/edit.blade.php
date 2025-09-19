@extends('layouts.app')

@section('title', 'Editar Personal')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Editar Personal</h1>

    <form action="{{ route('personal.update', $p->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $p->nombre) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $p->apellido) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control" value="{{ old('cedula', $p->cedula) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $p->telefono) }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $p->direccion) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $p->email) }}">
        </div>

        <!-- Vehículo -->
        <h5 class="mt-4">Vehículo</h5>
        <div class="mb-3">
            <label for="trae_vehiculo" class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="trae_vehiculo" class="form-control">
                <option value="0" {{ old('trae_vehiculo', $p->trae_vehiculo) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo', $p->trae_vehiculo) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <div id="vehiculoFields" style="{{ old('trae_vehiculo', $p->trae_vehiculo) ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="placa" class="form-label">Placa</label>
                    <input type="text" name="placa" id="placa" class="form-control" value="{{ old('placa', $p->placa) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control" value="{{ old('marca', $p->marca) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo', $p->modelo) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" name="color" id="color" class="form-control" value="{{ old('color', $p->color) }}">
                </div>
            </div>
        </div>

        <!-- PC -->
        <h5 class="mt-4">Computador</h5>
        <div class="mb-3">
            <label for="trae_pc" class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="trae_pc" class="form-control">
                <option value="0" {{ old('trae_pc', $p->trae_pc) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc', $p->trae_pc) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <div id="pcFields" style="{{ old('trae_pc', $p->trae_pc) ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="codigo_pc" class="form-label">Código PC</label>
                    <input type="text" name="codigo_pc" id="codigo_pc" class="form-control" value="{{ old('codigo_pc', $p->codigo_pc) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="serial_pc" class="form-label">Serial PC (últimos 4 dígitos)</label>
                    <input type="text" name="serial_pc" id="serial_pc" maxlength="4" class="form-control" value="{{ old('serial_pc', $p->serial_pc) }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('personal.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    document.getElementById('trae_vehiculo').addEventListener('change', function () {
        document.getElementById('vehiculoFields').style.display = this.value == '1' ? 'block' : 'none';
    });

    document.getElementById('trae_pc').addEventListener('change', function () {
        document.getElementById('pcFields').style.display = this.value == '1' ? 'block' : 'none';
    });
</script>
@endsection
