@extends('layouts.app')

@section('title', 'Gestión de ' . ucfirst($rol))

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Gestión de {{ ucfirst($rol) }}</h1>

    <a href="{{ route($rol . '.create') }}" class="btn btn-success mb-3">
        + Nuevo {{ ucfirst(Str::singular($rol)) }}
    </a>

    <div id="alert-container"></div>

    <!-- 🔹 Cambié el enlace por un botón que abre el modal -->
    <button class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#filtroReporteModal">
        📄 Generar Reporte PDF
    </button>

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
                    @if($usuario->pc)
                        💻 Serial: {{ $usuario->pc->serial }}
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
                            data-url="{{ route($rol . '.activar', $usuario->id) }}"
                            data-action="activar">Activar</button>
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

<!-- 🔹 Modal de filtros -->
<div class="modal fade" id="filtroReporteModal" tabindex="-1" aria-labelledby="filtroReporteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route($rol . '.reporte') }}" method="GET" target="_blank">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filtroReporteLabel">Filtros para el reporte</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          
          <!-- Campos a incluir -->
          <label class="form-label">Campos a incluir:</label>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="nombre" checked> <label class="form-check-label">Nombre</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="apellido" checked> <label class="form-check-label">Apellido</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="cedula"> <label class="form-check-label">Cédula</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="telefono"> <label class="form-check-label">Teléfono</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="email" checked> <label class="form-check-label">Email</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="direccion"> <label class="form-check-label">Dirección</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="vehiculo"> <label class="form-check-label">Vehículo</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="pc"> <label class="form-check-label">PC</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" name="campos[]" value="estado"> <label class="form-check-label">Estado</label></div>

          <hr>

          <!-- Filtro de estado -->
          <label class="form-label">Estado:</label>
          <select name="estado" class="form-select">
            <option value="">Todos</option>
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
          </select>

          <hr>

          <!-- Rango de fechas -->
          <label class="form-label">Fecha de registro:</label>
          <input type="date" name="fecha_inicio" class="form-control mb-2">
          <input type="date" name="fecha_fin" class="form-control">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Generar PDF</button>
        </div>
      </div>
    </form>
  </div>
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
