@extends('layouts.app')

@section('title', 'Editar ' . ucfirst(Str::singular($rol)))

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Editar {{ ucfirst(Str::singular($rol)) }}</h1>

    <form action="{{ route($rol . '.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3"><label class="form-label">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido', $usuario->apellido) }}" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Cédula</label>
                <input type="text" name="cedula" value="{{ old('cedula', $usuario->cedula) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3"><label class="form-label">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="form-control">
            </div>
        </div>

        <div class="mb-3"><label class="form-label">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $usuario->direccion) }}" class="form-control">
        </div>

        <div class="mb-3"><label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control">
        </div>

        <!-- Vehículo -->
        <h5 class="mt-4">Vehículo</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="trae_vehiculo" class="form-control">
                <option value="0" {{ old('trae_vehiculo', $usuario->vehiculo ? 1 : 0) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo', $usuario->vehiculo ? 1 : 0) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div id="vehiculoFields" style="{{ old('trae_vehiculo', $usuario->vehiculo ? 1 : 0) ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-3 mb-3"><label class="form-label">Placa</label>
                    <input type="text" name="placa" value="{{ old('placa', $usuario->vehiculo->placa ?? '') }}" class="form-control"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Marca</label>
                    <input type="text" name="marca" value="{{ old('marca', $usuario->vehiculo->marca ?? '') }}" class="form-control"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo', $usuario->vehiculo->modelo ?? '') }}" class="form-control"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Color</label>
                    <input type="text" name="color" value="{{ old('color', $usuario->vehiculo->color ?? '') }}" class="form-control"></div>
            </div>
        </div>

        <!-- PC -->
        <h5 class="mt-4">Computador</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="trae_pc" class="form-control">
                <option value="0" {{ old('trae_pc', $usuario->pc ? 1 : 0) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc', $usuario->pc ? 1 : 0) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div id="pcFields" style="{{ old('trae_pc', $usuario->pc ? 1 : 0) ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Serial PC</label>
                    <input type="text" name="serial" value="{{ old('serial', $usuario->pc->serial ?? '') }}" class="form-control"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route($rol . '.index') }}" class="btn btn-secondary">Cancelar</a>
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
