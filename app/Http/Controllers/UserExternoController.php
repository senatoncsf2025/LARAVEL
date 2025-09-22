<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExterno;
use App\Models\Movimiento;
use Barryvdh\DomPDF\Facade\Pdf;

class UserExternoController extends Controller
{
    // 📌 Listado por rol
    public function index(Request $request, $rol)
    {
        $usuarios = UserExterno::with(['vehiculo', 'pc'])
            ->where('rol_externo', $rol)
            ->get();

        return view("crud.$rol.index", compact('usuarios', 'rol'));
    }

    // 📌 Formulario creación
    public function create(Request $request, $rol)
    {
        return view("crud.$rol.create", compact('rol'));
    }

    // 📌 Guardar usuario (CRUD interno, dashboard)
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
            'placa'     => 'nullable|string|max:10|unique:vehiculos,placa',
            'marca'     => 'nullable|string|max:50',
            'modelo'    => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',

            // PC
            'trae_pc'   => 'nullable|boolean',
            'serial'    => 'nullable|string|max:20|unique:pcs,serial',
        ]);

        $usuario = UserExterno::create([
            'nombre'      => $request->nombre,
            'apellido'    => $request->apellido,
            'cedula'      => $request->cedula,
            'telefono'    => $request->telefono,
            'email'       => $request->email,
            'direccion'   => $request->direccion,
            'rol_externo' => $rol,
            'activo'      => true,
        ]);

        if ($request->trae_vehiculo) {
            $usuario->vehiculo()->create([
                'placa'  => $request->placa,
                'marca'  => $request->marca,
                'modelo' => $request->modelo,
                'color'  => $request->color,
            ]);
        }

        if ($request->trae_pc) {
            $usuario->pc()->create([
                'serial' => $request->serial,
            ]);
        }

        return redirect()->route("$rol.index")
            ->with('success', ucfirst($rol) . ' registrado correctamente.');
    }

    // 📌 Guardar visitante (formulario público en /registro)
    public function storeVisitante(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'email'        => 'nullable|email',
            'telefono'     => 'nullable|string|max:20',
            'cedula'       => 'nullable|string|max:20|unique:users_externos,cedula',
            'direccion'    => 'nullable|string|max:255',
            'fecha_visita' => 'nullable|date',
            'horario'      => 'nullable|string|max:10',
        ]);

        $usuario = UserExterno::create([
            'nombre'       => $request->nombre,
            'apellido'     => null,
            'cedula'       => $request->cedula,
            'telefono'     => $request->telefono,
            'email'        => $request->email,
            'direccion'    => $request->direccion,
            'rol_externo'  => 'visitante',  // 🔑 Rol fijo
            'activo'       => true,
            'fecha_visita' => $request->fecha_visita,
            'horario'      => $request->horario,
        ]);

        if ($request->trae_vehiculo) {
            $usuario->vehiculo()->create([
                'placa'  => $request->placa,
                'marca'  => $request->marca,
                'modelo' => $request->modelo,
                'color'  => $request->color,
            ]);
        }

        if ($request->trae_pc) {
            $usuario->pc()->create([
                'serial' => $request->serial_pc,
            ]);
        }

        return back()->with('success', 'Visita registrada correctamente.');
    }

    // 📌 Editar
    public function edit($id, $rol)
    {
        $usuario = UserExterno::with(['vehiculo', 'pc'])->findOrFail($id);

        return view("crud.$rol.edit", compact('usuario', 'rol'));
    }

    // 📌 Actualizar
    public function update(Request $request, $id, $rol)
    {
        $usuario = UserExterno::with(['vehiculo', 'pc'])->findOrFail($id);

        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'nullable|string|max:100',
            'cedula'    => "required|numeric|unique:users_externos,cedula,$id",
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email',
            'direccion' => 'nullable|string|max:255',

            // Vehículo
            'trae_vehiculo' => 'nullable|boolean',
            'placa'     => 'nullable|string|max:10|unique:vehiculos,placa,' . optional($usuario->vehiculo)->id,
            'marca'     => 'nullable|string|max:50',
            'modelo'    => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',

            // PC
            'trae_pc'   => 'nullable|boolean',
            'serial'    => 'nullable|string|max:20|unique:pcs,serial,' . optional($usuario->pc)->id,
        ]);

        $usuario->update($request->only(['nombre', 'apellido', 'cedula', 'telefono', 'email', 'direccion']));

        if ($request->trae_vehiculo) {
            $usuario->vehiculo()->updateOrCreate(
                ['user_externo_id' => $usuario->id],
                [
                    'placa'  => $request->placa,
                    'marca'  => $request->marca,
                    'modelo' => $request->modelo,
                    'color'  => $request->color,
                ]
            );
        } else {
            if ($usuario->vehiculo) $usuario->vehiculo->delete();
        }

        if ($request->trae_pc) {
            $usuario->pc()->updateOrCreate(
                ['user_externo_id' => $usuario->id],
                ['serial' => $request->serial]
            );
        } else {
            if ($usuario->pc) $usuario->pc->delete();
        }

        return redirect()->route("$rol.index")
            ->with('success', ucfirst($rol) . ' actualizado correctamente.');
    }

    // 📌 Inactivar
    public function inactivar($id, $rol)
    {
        $usuario = UserExterno::findOrFail($id);
        $usuario->update(['activo' => false]);

        return request()->ajax()
            ? response()->json(['success' => true, 'message' => ucfirst($rol) . ' inactivado correctamente.'])
            : back()->with('success', ucfirst($rol) . ' inactivado correctamente.');
    }

    // 📌 Activar
    public function activar($id, $rol)
    {
        $usuario = UserExterno::findOrFail($id);
        $usuario->update(['activo' => true]);

        return request()->ajax()
            ? response()->json(['success' => true, 'message' => ucfirst($rol) . ' activado correctamente.'])
            : back()->with('success', ucfirst($rol) . ' activado correctamente.');
    }

    // 📌 Reporte en PDF
    public function reporte($rol)
    {
        $usuarios = UserExterno::with(['vehiculo', 'pc'])
            ->where('rol_externo', $rol)
            ->get();

        $pdf = Pdf::loadView("crud.$rol.reporte", compact('usuarios', 'rol'));
        return $pdf->download("reporte_{$rol}.pdf");
    }

    // 📌 Registrar movimiento
    public function registrarMovimiento(Request $request, $rol)
    {
        $request->validate([
            'cedula' => 'required|numeric',
            'tipo'   => 'required|in:ingreso,salida',
            'observaciones' => 'nullable|string|max:255',
            'trae_vehiculo' => 'nullable|boolean',
            'placa' => 'nullable|string|max:10',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'color'  => 'nullable|string|max:30',
            'trae_pc' => 'nullable|boolean',
            'serial' => 'nullable|string|max:20',
        ]);

        $usuario = UserExterno::where('cedula', $request->cedula)
            ->where('rol_externo', $rol)
            ->first();

        if (!$usuario) {
            return back()->with('error', 'No se encontró un usuario con esa cédula en ' . ucfirst($rol));
        }

        if ($request->trae_vehiculo) {
            $usuario->vehiculo()->updateOrCreate(
                ['user_externo_id' => $usuario->id],
                [
                    'placa'  => $request->placa,
                    'marca'  => $request->marca,
                    'modelo' => $request->modelo,
                    'color'  => $request->color,
                ]
            );
        }

        if ($request->trae_pc) {
            $usuario->pc()->updateOrCreate(
                ['user_externo_id' => $usuario->id],
                ['serial' => $request->serial]
            );
        }

        Movimiento::create([
            'user_externo_id' => $usuario->id,
            'nombre'          => $usuario->nombre,
            'cedula'          => $usuario->cedula,
            'tipo'            => $request->tipo,
            'fecha_hora'      => now(),
            'observaciones'   => $request->observaciones,
        ]);

        return redirect()->back()->with('success', 'Movimiento de ' . ucfirst($request->tipo) . ' registrado correctamente.');
    }
}
