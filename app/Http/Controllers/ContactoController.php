<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'institucion' => 'required|string',
            'email' => 'required|email|regex:/\.edu\.co$/',
            'telefono' => 'required|regex:/^3\d{9}$/',
            'mensaje' => 'required|min:10'
        ]);

        Contacto::create($request->all());

        return redirect()->route('contacto.index')
            ->with('success', 'Formulario enviado y guardado con éxito.');
    }
}
