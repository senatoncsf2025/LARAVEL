<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de {{ ucfirst($rol) }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reporte de {{ ucfirst($rol) }}</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Vehículo</th>
                <th>PC</th>
                <th>Estado</th>
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
                        @if($u->vehiculo)
                            {{ $u->vehiculo->placa }} ({{ $u->vehiculo->marca }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($u->pc)
                            {{ $u->pc->codigo_pc }} ({{ $u->pc->serial_pc }})
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $u->activo ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
