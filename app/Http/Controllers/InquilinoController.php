<?php

namespace App\Http\Controllers;

use App\Models\Inquilino;
use Illuminate\Http\Request;

class InquilinoController extends Controller
{
    // Listar inquilinos
    public function index()
    {
        $inquilinos = Inquilino::withCount('alquileres')
            ->orderBy('nombre')
            ->paginate(10);

        return view('inquilinos.index', compact('inquilinos'));
    }

    // Formulario de registro
    public function create()
    {
        return view('inquilinos.create');
    }

    // Guardar inquilino
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|digits:8|unique:inquilinos,dni',
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:15',
        ]);

        Inquilino::create($request->only([
            'dni',
            'nombre',
            'telefono',
        ]));

        return redirect()
            ->route('inquilinos.index')
            ->with('success', 'Inquilino registrado correctamente.');
    }

    // Ver información
    public function show(Inquilino $inquilino)
    {
        $inquilino->load('alquileres.habitacion');

        return view('inquilinos.show', compact('inquilino'));
    }

    // Formulario de edición
    public function edit(Inquilino $inquilino)
    {
        return view('inquilinos.edit', compact('inquilino'));
    }

    // Actualizar información
    public function update(Request $request, Inquilino $inquilino)
    {
        $request->validate([
            'dni' => 'required|digits:8|unique:inquilinos,dni,' . $inquilino->id,
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:15',
        ]);

        $inquilino->update($request->only([
            'dni',
            'nombre',
            'telefono',
        ]));

        return redirect()
            ->route('inquilinos.index')
            ->with('success', 'Inquilino actualizado correctamente.');
    }

    // Eliminar inquilino
    public function destroy(Inquilino $inquilino)
    {
        if ($inquilino->alquileres()->exists()) {
            return redirect()
                ->route('inquilinos.index')
                ->with('error', 'No puedes eliminar un inquilino con historial de alquileres.');
        }

        $inquilino->delete();

        return redirect()
            ->route('inquilinos.index')
            ->with('success', 'Inquilino eliminado correctamente.');
    }
}
