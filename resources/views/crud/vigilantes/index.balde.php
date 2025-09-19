@extends('layouts.app')

@section('title', 'Gestión de Vigilantes')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de Vigilantes</h1>

    <a href="{{ route('vigilantes.create') }}" class="btn btn-success mb-3">+ Nuevo Vigilante</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Código Vigilante</th>
                <th>Cargo</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Vehículo</th>
                <th>PC</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vigilantes as $v)
                <tr>
                    <td>{{ $v->nombre }}</td>
                    <td>{{ $v->apellido }}</td>
                    <td>{{ $v->cedula }}</td>
                    <td>{{ $v->codigo_vigilante }}</td>
                    <td>{{ $v->cargo }}</td>
                    <td>{{ $v->telefono }}</td>
                    <td>{{ $v->email }}</td>
                    <td>
                        @if($v->trae_vehiculo)
                            🚗 {{ $v->placa }} ({{ $v->marca }} {{ $v->modelo }}, {{ $v->color }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($v->trae_pc)
                            💻 {{ $v->codigo_pc }} (Serial: {{ $v->serial_pc }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($v->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('vigilantes.edit', $v->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('vigilantes.destroy', $v->id) }}" method="POST" class="d-inline">
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
