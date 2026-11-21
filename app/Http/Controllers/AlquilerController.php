<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Models\Habitacion;
use App\Models\Inquilino;
use App\Models\CuotaAlquiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlquilerController extends Controller
{
    public function index()
    {
        $alquileres = Alquiler::with(['habitacion', 'inquilino'])
            ->latest()
            ->paginate(10);

        return view('alquileres.index', compact('alquileres'));
    }

    public function create()
    {
        $habitaciones = Habitacion::whereDoesntHave(
            'alquileres',
            fn($q) => $q->where('estado', 'activo')
        )->orderBy('numero')->get();

        $inquilinos = Inquilino::orderBy('nombre')->get();

        return view('alquileres.create', compact(
            'habitaciones',
            'inquilinos'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:habitaciones,id',
            'tenant_id' => 'required|exists:inquilinos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'mensualidad' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {

            $habitacion = Habitacion::whereKey($request->room_id)
                ->lockForUpdate()
                ->firstOrFail();

            $inicio = Carbon::parse($request->fecha_inicio);
            $fin = $request->fecha_fin
                ? Carbon::parse($request->fecha_fin)
                : null;

            $ocupada = Alquiler::where('room_id', $habitacion->id)
                ->where('estado', 'activo')
                ->whereDate('fecha_inicio', '<=', $fin ?? '9999-12-31')
                ->where(function ($q) use ($inicio) {
                    $q->whereNull('fecha_fin')
                        ->orWhereDate('fecha_fin', '>=', $inicio);
                })
                ->exists();

            if ($ocupada) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'room_id' => 'La habitación ya tiene un alquiler activo en esas fechas.',
                ]);
            }

            $alquiler = Alquiler::create([
                'room_id' => $habitacion->id,
                'tenant_id' => $request->tenant_id,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
                'mensualidad' => $request->mensualidad,
                'estado' => 'activo',
            ]);


            // Generar cuotas mensuales con vencimiento
            // el mismo día del mes siguiente.

            $limite = $fin
                ? $fin->copy()
                : $inicio->copy()->addMonthsNoOverflow(11);

            $fechaPeriodo = $inicio->copy();
            $contador = 0;

            while ($fechaPeriodo <= $limite && $contador < 12) {

                // Vencimiento: misma fecha del siguiente mes
                $fechaVencimiento = $fechaPeriodo->copy()
                    ->addMonthNoOverflow();

                CuotaAlquiler::create([
                    'rental_id' => $alquiler->id,
                    'periodo' => $fechaPeriodo->format('Y-m'),
                    'monto' => $request->mensualidad,
                    'fecha_vencimiento' => $fechaVencimiento,
                ]);

                $fechaPeriodo->addMonthNoOverflow();
                $contador++;
            }
        });

        return redirect()
            ->route('alquileres.index')
            ->with('success', 'Alquiler registrado y cuotas generadas correctamente.');
    }

    public function show(Alquiler $alquiler)
    {
        $alquiler->load([
            'habitacion',
            'inquilino',
            'cuotas.detallesPago'
        ]);

        return view('alquileres.show', compact('alquiler'));
    }

    public function edit(Alquiler $alquiler)
    {
        return view('alquileres.edit', compact('alquiler'));
    }

    public function update(Request $request, Alquiler $alquiler)
    {
        $request->validate([
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'mensualidad' => 'required|numeric|min:0.01',
        ]);

        $alquiler->update($request->only([
            'fecha_fin',
            'mensualidad',
        ]));

        return redirect()
            ->route('alquileres.index')
            ->with('success', 'Alquiler actualizado correctamente.');
    }

    public function destroy(Alquiler $alquiler)
    {
        if ($alquiler->cuotas()->exists()) {
            return back()->with(
                'error',
                'No puedes eliminar un alquiler que ya tiene cuotas registradas.'
            );
        }

        $alquiler->delete();

        return redirect()
            ->route('alquileres.index')
            ->with('success', 'Alquiler eliminado correctamente.');
    }
}
