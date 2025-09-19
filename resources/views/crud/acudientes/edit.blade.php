@extends('layouts.app')

@section('title', 'Editar {{ ucfirst(Str::singular($rol)) }}')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Editar {{ ucfirst(Str::singular($rol)) }}</h1>

    {{-- Bloque de errores generales --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ups, hubo algunos errores:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route($rol . '.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre', $usuario->nombre) }}" required>
                @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                    value="{{ old('apellido', $usuario->apellido) }}">
                @error('apellido')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
                    value="{{ old('cedula', $usuario->cedula) }}" required>
                @error('cedula')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                    value="{{ old('telefono', $usuario->telefono) }}">
                @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                value="{{ old('direccion', $usuario->direccion) }}">
            @error('direccion')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $usuario->email) }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Vehículo -->
        <h5 class="mt-4">Vehículo</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="trae_vehiculo"
                class="form-control @error('trae_vehiculo') is-invalid @enderror">
                <option value="0" {{ old('trae_vehiculo', $usuario->trae_vehiculo) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo', $usuario->trae_vehiculo) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
            @error('trae_vehiculo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="vehiculoFields"
            style="{{ old('trae_vehiculo', $usuario->trae_vehiculo) ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Placa</label>
                    <input type="text" name="placa" class="form-control @error('placa') is-invalid @enderror"
                        value="{{ old('placa', $usuario->placa) }}">
                    @error('placa')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Marca</label>
                    <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror"
                        value="{{ old('marca', $usuario->marca) }}">
                    @error('marca')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                        value="{{ old('modelo', $usuario->modelo) }}">
                    @error('modelo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control @error('color') is-invalid @enderror"
                        value="{{ old('color', $usuario->color) }}">
                    @error('color')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- PC -->
        <h5 class="mt-4">Computador</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="trae_pc" class="form-control @error('trae_pc') is-invalid @enderror">
                <option value="0" {{ old('trae_pc', $usuario->trae_pc) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc', $usuario->trae_pc) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
            @error('trae_pc')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="pcFields" style="{{ old('trae_pc', $usuario->trae_pc) ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Código PC</label>
                    <input type="text" name="codigo_pc" class="form-control @error('codigo_pc') is-invalid @enderror"
                        value="{{ old('codigo_pc', $usuario->codigo_pc) }}">
                    @error('codigo_pc')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Serial PC</label>
                    <input type="text" name="serial_pc" maxlength="4"
                        class="form-control @error('serial_pc') is-invalid @enderror"
                        value="{{ old('serial_pc', $usuario->serial_pc) }}">
                    @error('serial_pc')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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