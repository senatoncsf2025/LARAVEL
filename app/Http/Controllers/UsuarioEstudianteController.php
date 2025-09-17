<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioEstudiante;
use App\Models\IngresoEstudiante;
use Carbon\Carbon;

class UsuarioEstudianteController extends Controller
{
    // Mostrar la vista de consulta y registro
    public function index()
    {
        return view('estudiantes.consulta_registro'); // nombre del blade que usarás
    }

    // Registrar usuario por primera vez
    public function registrarUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'correo' => 'required|email|unique:usuarios__estudiantes,correo',
            'codigo_portatil' => 'nullable|digits:4',
            'telefono' => 'required|digits:10',
            'direccion' => 'required|string',
        ]);

        $usuario = UsuarioEstudiante::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'codigo_portatil' => $request->codigo_portatil,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return response()->json([
            'success' => true,
            'usuario_id' => $usuario->id,
            'message' => 'Usuario registrado correctamente.'
        ]);
    }

    // Consultar usuario y registrar entrada o salida
    public function consultarUsuario(Request $request)
    {
        $request->validate([
            'documento' => 'required|email', // asumimos que correo es el identificador
            'codigo_pc' => 'nullable|digits:4',
        ]);

        $usuario = UsuarioEstudiante::where('correo', $request->documento)
                    ->where(function($q) use ($request) {
                        if ($request->codigo_pc) {
                            $q->where('codigo_portatil', $request->codigo_pc);
                        }
                    })
                    ->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ]);
        }

        // Registrar ingreso
        $ultimoIngreso = $usuario->ingresos()->latest('fecha_hora')->first();
        $tipo = 'entrada';

        if ($ultimoIngreso && $ultimoIngreso->tipo === 'entrada') {
            $tipo = 'salida';
        }

        $ingreso = IngresoEstudiante::create([
            'usuario_id' => $usuario->id,
            'tipo' => $tipo,
            'fecha_hora' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'usuario' => $usuario,
            'tipo' => $tipo,
            'fecha_hora' => $ingreso->fecha_hora->format('Y-m-d H:i:s')
        ]);
    }
}
