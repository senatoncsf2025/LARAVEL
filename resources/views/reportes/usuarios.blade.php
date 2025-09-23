<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de {{ ucfirst($rol) }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Reporte de {{ ucfirst($rol) }}</h2>

    <table>
        <thead>
            <tr>
                @foreach($campos as $campo)
                    <th>{{ ucfirst($campo) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    @foreach($campos as $campo)
                        <td>
                            @if($campo === 'vehiculo' && $usuario->vehiculo)
                                🚗 {{ $usuario->vehiculo->placa }}
                                ({{ $usuario->vehiculo->marca }} {{ $usuario->vehiculo->modelo }}, {{ $usuario->vehiculo->color }})
                            @elseif($campo === 'pc' && $usuario->pc)
                                💻 Serial: {{ $usuario->pc->serial }}
                            @else
                                {{ $usuario->$campo ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($campos) }}" style="text-align:center;">
                        No hay registros disponibles
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><small>Generado el {{ now()->format('d/m/Y H:i') }}</small></p>
</body>
</html>
