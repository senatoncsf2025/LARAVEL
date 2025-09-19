@extends('layouts.app')

@section('title', 'Gestión de {{ ucfirst($rol) }}')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de {{ ucfirst($rol) }}</h1>

    <a href="{{ route($rol . '.create') }}" class="btn btn-success mb-3">+ Nuevo {{ ucfirst(Str::singular($rol)) }}</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route($rol . '.reporte') }}" class="btn btn-info mb-3" target="_blank">
        📄 Generar Reporte PDF
    </a>

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
            @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->apellido }}</td>
                <td>{{ $usuario->cedula }}</td>
                <td>{{ $usuario->telefono }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->direccion }}</td>
                <td>
                    @if($usuario->trae_vehiculo)
                    🚗 {{ $usuario->placa }} ({{ $usuario->marca }} {{ $usuario->modelo }}, {{ $usuario->color }})
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($usuario->trae_pc)
                    💻 {{ $usuario->codigo_pc }} (Serial: {{ $usuario->serial_pc }})
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($usuario->activo)
                    <span class="badge bg-success">Activo</span>
                    @else
                    <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route($rol . '.edit', $usuario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route($rol . '.destroy', $usuario->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Inactivar este registro?')">Inactivar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10">No hay registros</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection