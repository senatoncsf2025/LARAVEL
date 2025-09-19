@extends('layouts.app')

@section('title', 'Gestión de Oficinas')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de Oficinas</h1>

    <a href="{{ route('oficinas.create') }}" class="btn btn-success mb-3">+ Nueva Oficina</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $u)
                <tr>
                    <td>{{ $u->nombre }} {{ $u->apellido }}</td>
                    <td>{{ $u->cedula }}</td>
                    <td>{{ $u->telefono }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('oficinas.edit', $u->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('oficinas.destroy', $u->id) }}" method="POST" class="d-inline">
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
