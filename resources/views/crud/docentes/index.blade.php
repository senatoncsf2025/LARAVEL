@extends('layouts.app')

@section('title', 'Gestión de Docentes')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de Docentes</h1>

    <a href="{{ route('docentes.create') }}" class="btn btn-success mb-3">+ Nuevo Docente</a>

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
            @foreach($docentes as $docente)
                <tr>
                    <td>{{ $docente->nombre }}</td>
                    <td>{{ $docente->apellido }}</td>
                    <td>{{ $docente->cedula }}</td>
                    <td>{{ $docente->telefono }}</td>
                    <td>{{ $docente->email }}</td>
                    <td>{{ $docente->direccion }}</td>
                    <td>
                        @if($docente->trae_vehiculo)
                            🚗 {{ $docente->placa }} ({{ $docente->marca }} {{ $docente->modelo }}, {{ $docente->color }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($docente->trae_pc)
                            💻 {{ $docente->codigo_pc }} (Serial: {{ $docente->serial_pc }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($docente->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('docentes.edit', $docente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST" class="d-inline">
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
