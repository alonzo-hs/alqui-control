<?php

namespace App\Http\Controllers;

use App\Models\CuotaAlquiler;
use Carbon\Carbon;

class DeudaController extends Controller
{
    public function index()
    {
        $cuotas = CuotaAlquiler::with([
            'alquiler.inquilino',
            'alquiler.habitacion',
            'detallesPago',
        ])
        ->orderBy('fecha_vencimiento')
        ->get();

        // Calcular las deudas
        $deudas = $cuotas->map(function ($cuota) {

            $pagado = $cuota->detallesPago
                ->sum('monto_asignado');

            $saldo = round($cuota->monto - $pagado, 2);

            return [
                'cuota' => $cuota,
                'pagado' => $pagado,
                'saldo' => max(0, $saldo),
                'estado' => $saldo <= 0
                    ? 'Pagada'
                    : (Carbon::parse($cuota->fecha_vencimiento)
                        ->lt(Carbon::today())
                        ? 'Vencida'
                        : 'Pendiente'),
            ];
        })
        ->filter(fn ($item) => $item['saldo'] > 0)
        ->values();

        $totalDeuda = $deudas->sum('saldo');

        $totalVencido = $deudas
            ->where('estado', 'Vencida')
            ->sum('saldo');

        $totalPendiente = $deudas
            ->where('estado', 'Pendiente')
            ->sum('saldo');

        return view('deudas.index', compact(
            'deudas',
            'totalDeuda',
            'totalVencido',
            'totalPendiente'
        ));
    }
}
