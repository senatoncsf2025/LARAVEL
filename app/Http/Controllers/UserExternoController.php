<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExterno;

class UserExternoController extends Controller
{
    /**
     * Listar registros de un rol específico
     */
    public function index(Request $request, $rol)
    {
        $usuarios = UserExterno::where('rol_externo', $rol)->get();

        // Creamos un nombre de variable dinámico según el rol
        $variableName = $rol;

        // Pasamos la variable con el nombre correcto a la vista
        return view("crud.$rol.index", [
            $variableName => $usuarios,
            'rol' => $rol
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request, $rol)
    {
        return view("crud.$rol.create", compact('rol'));
    }

    /**
     * Guardar nuevo registro
     */
    public function store(Request $request, $rol)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'nullable|string|max:100',
            'cedula'    => 'required|numeric|unique:users_externos,cedula',
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email',
            'direccion' => 'nullable|string|max:255',
            'codigo_pc' => 'nullable|string|max:10',
            'trae_vehiculo' => 'boolean',
            'placa'     => 'nullable|string|max:10',
            'marca'     => 'nullable|string|max:50',
            'modelo'    => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',
            'trae_pc'   => 'boolean',
            'serial_pc' => 'nullable|string|max:4',
        ]);

        UserExterno::create([
            ...$request->all(),
            'rol_externo' => $rol,
            'activo' => true,
        ]);

        return redirect()->route("$rol.index")->with('success', ucfirst($rol) . ' registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($rol, $id)
    {
        $usuario = UserExterno::where('rol_externo', $rol)->findOrFail($id);

        return view("crud.$rol.edit", [
            'usuario' => $usuario,
            'rol' => $rol
        ]);
    }

    /**
     * Actualizar registro
     */
    public function update(Request $request, $rol, $id)
    {
        $usuario = UserExterno::where('rol_externo', $rol)->findOrFail($id);

        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'nullable|string|max:100',
            'cedula'    => "required|numeric|unique:users_externos,cedula,$id",
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email',
            'direccion' => 'nullable|string|max:255',
            'codigo_pc' => 'nullable|string|max:10',
            'trae_vehiculo' => 'boolean',
            'placa'     => 'nullable|string|max:10',
            'marca'     => 'nullable|string|max:50',
            'modelo'    => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',
            'trae_pc'   => 'boolean',
            'serial_pc' => 'nullable|string|max:4',
        ]);

        $usuario->update($request->all());

        return redirect()->route("$rol.index")->with('success', ucfirst($rol) . ' actualizado correctamente.');
    }

    /**
     * Inactivar registro (no borrar)
     */
    public function destroy($rol, $id)
    {
        $usuario = UserExterno::where('rol_externo', $rol)->findOrFail($id);
        $usuario->update(['activo' => false]);

        return redirect()->route("$rol.index")->with('success', ucfirst($rol) . ' inactivado correctamente.');
    }
}
