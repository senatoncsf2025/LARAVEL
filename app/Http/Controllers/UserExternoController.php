<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExterno;
use App\Models\Vehiculo;
use App\Models\Pc;
use Barryvdh\DomPDF\Facade\Pdf; // 👈 importar DomPDF

class UserExternoController extends Controller
{
    /**
     * Listar registros de un rol específico
     */
    public function index(Request $request, $rol)
    {
        $usuarios = UserExterno::with(['vehiculo', 'pc'])
            ->where('rol_externo', $rol)
            ->get();

        return view("crud.$rol.index", compact('usuarios', 'rol'));
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

            // Vehículo
            'trae_vehiculo' => 'nullable|boolean',
            'placa'     => 'nullable|string|max:10',
            'marca'     => 'nullable|string|max:50',
            'modelo'    => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',

            // PC
            'trae_pc'   => 'nullable|boolean',
            'codigo_pc' => 'nullable|string|max:10',
            'serial_pc' => 'nullable|string|max:4',
        ]);

        // Guardar usuario externo
        $usuario = UserExterno::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'rol_externo' => $rol,
            'activo' => true,
        ]);

        // Guardar vehículo si aplica
        if ($request->trae_vehiculo) {
            $usuario->vehiculo()->create([
                'placa' => $request->placa,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'color' => $request->color,
            ]);
        }

        // Guardar PC si aplica
        if ($request->trae_pc) {
            $usuario->pc()->create([
                'codigo_pc' => $request->codigo_pc,
                'serial_pc' => $request->serial_pc,
            ]);
        }

        return redirect()->route("$rol.index")
            ->with('success', ucfirst($rol) . ' registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($rol, $id)
    {
        $usuario = UserExterno::with(['vehiculo', 'pc'])
            ->where('rol_externo', $rol)
            ->findOrFail($id);

        return view("crud.$rol.edit", compact('usuario', 'rol'));
    }

    /**
     * Actualizar registro
     */
    public function update(Request $request, $rol, $id)
    {
        $usuario = UserExterno::with(['vehiculo', 'pc'])
            ->where('rol_externo', $rol)
            ->findOrFail($id);

        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'nullable|string|max:100',
            'cedula'    => "required|numeric|unique:users_externos,cedula,$id",
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email',
            'direccion' => 'nullable|string|max:255',

            // Vehículo
            'trae_vehiculo' => 'nullable|boolean',
            'placa'     => 'nullable|string|max:10',
            'marca'     => 'nullable|string|max:50',
            'modelo'    => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',

            // PC
            'trae_pc'   => 'nullable|boolean',
            'codigo_pc' => 'nullable|string|max:10',
            'serial_pc' => 'nullable|string|max:4',
        ]);

        // Actualizar usuario
        $usuario->update($request->only([
            'nombre',
            'apellido',
            'cedula',
            'telefono',
            'email',
            'direccion'
        ]));

        // Vehículo
        if ($request->trae_vehiculo) {
            if ($usuario->vehiculo) {
                $usuario->vehiculo->update([
                    'placa' => $request->placa,
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'color' => $request->color,
                ]);
            } else {
                $usuario->vehiculo()->create([
                    'placa' => $request->placa,
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'color' => $request->color,
                ]);
            }
        } else {
            if ($usuario->vehiculo) {
                $usuario->vehiculo->delete();
            }
        }

        // PC
        if ($request->trae_pc) {
            if ($usuario->pc) {
                $usuario->pc->update([
                    'codigo_pc' => $request->codigo_pc,
                    'serial_pc' => $request->serial_pc,
                ]);
            } else {
                $usuario->pc()->create([
                    'codigo_pc' => $request->codigo_pc,
                    'serial_pc' => $request->serial_pc,
                ]);
            }
        } else {
            if ($usuario->pc) {
                $usuario->pc->delete();
            }
        }

        return redirect()->route("$rol.index")
            ->with('success', ucfirst($rol) . ' actualizado correctamente.');
    }

    /**
     * Inactivar registro (no borrar)
     */
    public function destroy(Request $request, $id)
    {
        // recuperar el rol desde defaults
        $rol = $request->route('rol');

        $usuario = UserExterno::where('rol_externo', $rol)
            ->where('id', $id)
            ->first();

        if (!$usuario) {
            return redirect()->route("$rol.index")
                ->with('error', 'El usuario no pertenece a este módulo o no existe.');
        }

        $usuario->update(['activo' => false]);

        return redirect()->route("$rol.index")
            ->with('success', ucfirst($rol) . ' inactivado correctamente.');
    }



    /**
     * Generar reporte en PDF
     */
    public function reporte($rol)
    {
        $usuarios = UserExterno::with(['vehiculo', 'pc'])
            ->where('rol_externo', $rol)
            ->get();

        $pdf = Pdf::loadView("crud.$rol.reporte", compact('usuarios', 'rol'));
        return $pdf->download("reporte_{$rol}.pdf");
    }
}
