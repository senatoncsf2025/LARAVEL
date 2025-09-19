<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExterno;

class EstudianteController extends Controller
{
    // Listado
    public function index()
    {
        $estudiantes = UserExterno::where('rol_externo', 'estudiante')->get();
        return view('crud.estudiantes.index', compact('estudiantes'));
    }

    // Formulario crear
    public function create()
    {
        return view('crud.estudiantes.create');
    }

    // Guardar nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'apellido'    => 'nullable|string|max:100',
            'cedula'      => 'required|numeric|unique:users_externos,cedula',
            'telefono'    => 'nullable|digits:10',
            'direccion'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:150',

            // PC
            'codigo_pc'   => 'nullable|string|max:50',
            'trae_pc'     => 'nullable|boolean',
            'serial_pc'   => 'nullable|string|max:10',

            // Vehículo
            'trae_vehiculo' => 'nullable|boolean',
            'placa'       => 'nullable|string|max:10',
            'marca'       => 'nullable|string|max:50',
            'modelo'      => 'nullable|string|max:50',
            'color'       => 'nullable|string|max:30',

            // Visita
            'fecha_visita' => 'nullable|date',
            'horario'      => 'nullable|string|max:20',
        ]);

        UserExterno::create([
            'nombre'       => $request->nombre,
            'apellido'     => $request->apellido,
            'cedula'       => $request->cedula,
            'telefono'     => $request->telefono,
            'direccion'    => $request->direccion,
            'email'        => $request->email,
            'rol_externo'  => 'estudiante',
            'codigo_pc'    => $request->codigo_pc,
            'trae_pc'      => $request->trae_pc ?? false,
            'serial_pc'    => $request->serial_pc,
            'trae_vehiculo'=> $request->trae_vehiculo ?? false,
            'placa'        => $request->placa,
            'marca'        => $request->marca,
            'modelo'       => $request->modelo,
            'color'        => $request->color,
            'fecha_visita' => $request->fecha_visita,
            'horario'      => $request->horario,
            'activo'       => true,
        ]);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante registrado correctamente.');
    }

    // Formulario editar
    public function edit($id)
    {
        $estudiante = UserExterno::findOrFail($id);
        return view('crud.estudiantes.edit', compact('estudiante'));
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $estudiante = UserExterno::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:100',
            'apellido'    => 'nullable|string|max:100',
            'cedula'      => 'required|numeric|unique:users_externos,cedula,' . $id,
            'telefono'    => 'nullable|digits:10',
            'direccion'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:150',

            'codigo_pc'   => 'nullable|string|max:50',
            'trae_pc'     => 'nullable|boolean',
            'serial_pc'   => 'nullable|string|max:10',

            'trae_vehiculo' => 'nullable|boolean',
            'placa'       => 'nullable|string|max:10',
            'marca'       => 'nullable|string|max:50',
            'modelo'      => 'nullable|string|max:50',
            'color'       => 'nullable|string|max:30',

            'fecha_visita' => 'nullable|date',
            'horario'      => 'nullable|string|max:20',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    // Inactivar (no borrar)
    public function destroy($id)
    {
        $estudiante = UserExterno::findOrFail($id);
        $estudiante->update(['activo' => false]);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante inactivado.');
    }
}
