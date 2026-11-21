<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\CuotaAlquiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['usuario', 'detalles.cuota.alquiler.inquilino'])
            ->latest('fecha')
            ->paginate(15);

        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $cuotas = CuotaAlquiler::with([
            'alquiler.inquilino',
            'alquiler.habitacion',
            'detallesPago',
        ])->orderBy('fecha_vencimiento')->get();

        return view('pagos.create', compact('cuotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'charge_id' => 'required|exists:cuotas_alquiler,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'metodo' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request) {

            $cuota = CuotaAlquiler::whereKey($request->charge_id)
                ->lockForUpdate()
                ->firstOrFail();

            $pagado = $cuota->detallesPago()->sum('monto_asignado');
            $saldo = round($cuota->monto - $pagado, 2);
            $monto = round((float) $request->monto, 2);

            if ($saldo <= 0 || $monto > $saldo) {
                throw ValidationException::withMessages([
                    'monto' => 'El importe supera el saldo pendiente de la cuota.',
                ]);
            }

            $pago = Pago::create([
                'fecha' => $request->fecha,
                'monto' => $monto,
                'metodo' => $request->metodo,
                'usuario_registrador' => auth()->id(),
            ]);

            $pago->detalles()->create([
                'charge_id' => $cuota->id,
                'monto_asignado' => $monto,
            ]);
        });

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(Pago $pago)
    {
        $pago->load(['usuario', 'detalles.cuota.alquiler.inquilino']);

        return view('pagos.show', compact('pago'));
    }
}
