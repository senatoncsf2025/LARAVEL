@extends('layouts.app')

@section('title', 'Gestión de Personal')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de Personal</h1>

    <a href="{{ route('personal.create') }}" class="btn btn-success mb-3">+ Nuevo Personal</a>

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
            @foreach($personal as $p)
                <tr>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->apellido }}</td>
                    <td>{{ $p->cedula }}</td>
                    <td>{{ $p->telefono }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->direccion }}</td>
                    <td>
                        @if($p->trae_vehiculo)
                            🚗 {{ $p->placa }} ({{ $p->marca }} {{ $p->modelo }}, {{ $p->color }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->trae_pc)
                            💻 {{ $p->codigo_pc }} (Serial: {{ $p->serial_pc }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('personal.edit', $p->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('personal.destroy', $p->id) }}" method="POST" class="d-inline">
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
