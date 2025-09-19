<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitante;

class VisitanteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'email'       => 'nullable|email',
            'telefono'    => 'nullable|digits:10',
            'cedula'      => 'nullable|numeric',
            'trae_vehiculo' => 'nullable|boolean',
            'placa'       => 'required_if:trae_vehiculo,1|string|max:10',
            'marca'       => 'required_if:trae_vehiculo,1|string|max:50',
            'modelo'      => 'required_if:trae_vehiculo,1|string|max:50',
            'color'       => 'required_if:trae_vehiculo,1|string|max:30',
            'trae_pc'     => 'nullable|boolean',
            'serial_pc'   => 'required_if:trae_pc,1|string|size:4',
            'dias'        => 'required|array',
            'horario'     => 'required|string',
        ]);

        // Guardar cada día de visita
        foreach ($request->dias as $dia) {
            Visitante::create([
                'nombre'      => $request->nombre,
                'email'       => $request->email,
                'telefono'    => $request->telefono,
                'cedula'      => $request->cedula,
                'trae_vehiculo' => $request->trae_vehiculo ?? false,
                'placa'       => $request->placa,
                'marca'       => $request->marca,
                'modelo'      => $request->modelo,
                'color'       => $request->color,
                'trae_pc'     => $request->trae_pc ?? false,
                'serial_pc'   => $request->serial_pc,
                'fecha_visita'=> $dia,
                'horario'     => $request->horario,
            ]);
        }

        return redirect()->back()->with('success', 'Registro de asistencia completado correctamente.');
    }
}
