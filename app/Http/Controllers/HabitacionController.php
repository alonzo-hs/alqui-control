<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    // Mostrar todas las habitaciones
    public function index()
    {
        $habitaciones = Habitacion::with('alquileres')
            ->orderBy('numero')
            ->paginate(10);

        return view('habitaciones.index', compact('habitaciones'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        return view('habitaciones.create');
    }

    // Guardar habitación
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:10|unique:habitaciones,numero',
            'piso' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Habitacion::create($request->only([
            'numero',
            'piso',
            'descripcion',
        ]));

        return redirect()
            ->route('habitaciones.index')
            ->with('success', 'Habitación registrada correctamente.');
    }

    // Mostrar una habitación
    public function show(Habitacion $habitacione)
    {
        return view('habitaciones.show', [
            'habitacion' => $habitacione
        ]);
    }

    // Mostrar formulario de edición
    public function edit(Habitacion $habitacione)
    {
        return view('habitaciones.edit', [
            'habitacion' => $habitacione
        ]);
    }

    // Actualizar habitación
    public function update(Request $request, Habitacion $habitacione)
    {
        $request->validate([
            'numero' => 'required|string|max:10|unique:habitaciones,numero,' . $habitacione->id,
            'piso' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $habitacione->update($request->only([
            'numero',
            'piso',
            'descripcion',
        ]));

        return redirect()
            ->route('habitaciones.index')
            ->with('success', 'Habitación actualizada correctamente.');
    }

    // Eliminar habitación
    public function destroy(Habitacion $habitacione)
    {
        if ($habitacione->alquileres()->exists()) {
            return redirect()
                ->route('habitaciones.index')
                ->with('error', 'No puedes eliminar una habitación con historial de alquileres.');
        }

        $habitacione->delete();

        return redirect()
            ->route('habitaciones.index')
            ->with('success', 'Habitación eliminada correctamente.');
    }
}
