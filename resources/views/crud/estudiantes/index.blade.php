@extends('layouts.app')

@section('title', 'Gestión de Estudiantes')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de Estudiantes</h1>

    <a href="{{ route('estudiantes.create') }}" class="btn btn-success mb-3">+ Nuevo Estudiante</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Vehículo</th>
                <th>PC</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantes as $estudiante)
                <tr>
                    <td>{{ $estudiante->nombre }}</td>
                    <td>{{ $estudiante->apellido }}</td>
                    <td>{{ $estudiante->cedula }}</td>
                    <td>{{ $estudiante->telefono }}</td>
                    <td>{{ $estudiante->email }}</td>
                    <td>{{ $estudiante->direccion }}</td>
                    <td>
                        @if($estudiante->trae_vehiculo)
                            🚗 {{ $estudiante->placa }} ({{ $estudiante->marca }} {{ $estudiante->modelo }}, {{ $estudiante->color }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($estudiante->trae_pc)
                            💻 {{ $estudiante->codigo_pc }} (Serial: {{ $estudiante->serial_pc }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($estudiante->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Inactivar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
