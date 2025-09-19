@extends('layouts.app')

@section('title', 'Editar Oficina')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Editar Oficina</h1>

    <form action="{{ route('oficinas.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control"
                    value="{{ old('nombre', $usuario->nombre) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control"
                    value="{{ old('apellido', $usuario->apellido) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control"
                    value="{{ old('cedula', $usuario->cedula) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control"
                    value="{{ old('telefono', $usuario->telefono) }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $usuario->email) }}">
        </div>

        {{-- Vehículo --}}
        <h5 class="mt-4">Vehículo</h5>
        <div class="mb-3">
            <label for="trae_vehiculo" class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="trae_vehiculo" class="form-control">
                <option value="0" {{ old('trae_vehiculo', $usuario->trae_vehiculo) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo', $usuario->trae_vehiculo) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        {{-- PC --}}
        <h5 class="mt-4">Computador</h5>
        <div class="mb-3">
            <label for="trae_pc" class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="trae_pc" class="form-control">
                <option value="0" {{ old('trae_pc', $usuario->trae_pc) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc', $usuario->trae_pc) == 1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('oficinas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
