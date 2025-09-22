@extends('layouts.app')

@section('title', 'Registrar ' . ucfirst(Str::singular($rol)))

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Registrar {{ ucfirst(Str::singular($rol)) }}</h1>

    {{-- Errores generales --}}
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

    <form action="{{ route($rol . '.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                       value="{{ old('apellido') }}">
                @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
                       value="{{ old('cedula') }}" required>
                @error('cedula') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                       value="{{ old('telefono') }}">
                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                   value="{{ old('direccion') }}">
            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Vehículo -->
        <h5 class="mt-4">Vehículo</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="trae_vehiculo" class="form-control">
                <option value="0" {{ old('trae_vehiculo') == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo') == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <div id="vehiculoFields" style="{{ old('trae_vehiculo') ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-3 mb-3"><label class="form-label">Placa</label>
                    <input type="text" name="placa" value="{{ old('placa') }}" class="form-control"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Marca</label>
                    <input type="text" name="marca" value="{{ old('marca') }}" class="form-control"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo') }}" class="form-control"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}" class="form-control"></div>
            </div>
        </div>

        <!-- PC -->
        <h5 class="mt-4">Computador</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="trae_pc" class="form-control">
                <option value="0" {{ old('trae_pc') == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc') == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <div id="pcFields" style="{{ old('trae_pc') ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Serial PC</label>
                    <input type="text" name="serial" value="{{ old('serial') }}" class="form-control"></div>
            </div>
        </div>

        <input type="hidden" name="rol_externo" value="{{ $rol }}">

        <button type="submit" class="btn btn-primary">Guardar</button>
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
