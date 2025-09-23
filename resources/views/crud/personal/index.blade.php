@extends('layouts.app')

@section('title', 'Gestión de ' . ucfirst($rol))

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de {{ ucfirst($rol) }}</h1>

    <a href="{{ route($rol . '.create') }}" class="btn btn-success mb-3">
        + Nuevo {{ ucfirst(Str::singular($rol)) }}
    </a>

    <div id="alert-container"></div>

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
            <tr data-id="{{ $usuario->id }}">
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->apellido }}</td>
                <td>{{ $usuario->cedula }}</td>
                <td>{{ $usuario->telefono }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->direccion }}</td>
                <td>
                    @if($usuario->vehiculo)
                    🚗 {{ $usuario->vehiculo->placa }}
                    ({{ $usuario->vehiculo->marca }} {{ $usuario->vehiculo->modelo }}, {{ $usuario->vehiculo->color }})
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($usuario->pc && $usuario->pc->serial)
                    {{ $usuario->pc->serial }}
                    @else
                    -
                    @endif
                </td>
                <td class="estado">
                    @if($usuario->activo)
                    <span class="badge bg-success">Activo</span>
                    @else
                    <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>
                <td class="acciones">
                    <a href="{{ route($rol . '.edit', $usuario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    @if($usuario->activo)
                    <button type="button" class="btn btn-danger btn-sm toggle-estado"
                        data-url="{{ route($rol . '.inactivar', $usuario->id) }}"
                        data-action="inactivar">Inactivar</button>
                    @else
                    <button type="button" class="btn btn-success btn-sm toggle-estado"
                        data-url="{{ route($rol . '.activar', $usuario->id) }}" data-action="activar">Activar</button>
                    @endif
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

@push('scripts')
<script>
    function toggleEstadoHandler(event) {
    const button = event.currentTarget;
    const url = button.dataset.url;
    const action = button.dataset.action;
    const row = button.closest('tr');
    const estadoCell = row.querySelector('.estado');
    const accionesCell = row.querySelector('.acciones');

    if (!confirm(`¿Seguro que deseas ${action} este registro?`)) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Mostrar alerta
            document.getElementById('alert-container').innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            // Actualizar estado y acciones
            if (action === 'inactivar') {
                estadoCell.innerHTML = '<span class="badge bg-secondary">Inactivo</span>';
                accionesCell.innerHTML = `
                    <a href="{{ url('dashboard/'.$rol) }}/${row.dataset.id}/edit" class="btn btn-warning btn-sm">Editar</a>
                    <button type="button" class="btn btn-success btn-sm toggle-estado"
                        data-url="{{ url('dashboard/'.$rol) }}/activar/${row.dataset.id}"
                        data-action="activar">Activar</button>
                `;
            } else {
                estadoCell.innerHTML = '<span class="badge bg-success">Activo</span>';
                accionesCell.innerHTML = `
                    <a href="{{ url('dashboard/'.$rol) }}/${row.dataset.id}/edit" class="btn btn-warning btn-sm">Editar</a>
                    <button type="button" class="btn btn-danger btn-sm toggle-estado"
                        data-url="{{ url('dashboard/'.$rol) }}/inactivar/${row.dataset.id}"
                        data-action="inactivar">Inactivar</button>
                `;
            }

            // Reenganchar evento al nuevo botón
            accionesCell.querySelectorAll('.toggle-estado').forEach(btn => {
                btn.addEventListener('click', toggleEstadoHandler);
            });

            // Ocultar alerta después de 5 segundos
            setTimeout(() => {
                let alert = document.querySelector('.alert');
                if (alert) alert.classList.remove('show');
            }, 5000);
        }
    })
    .catch(() => alert("Error al procesar la solicitud"));
}

// Enganchar eventos al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-estado').forEach(button => {
        button.addEventListener('click', toggleEstadoHandler);
    });
});
</script>
@endpush