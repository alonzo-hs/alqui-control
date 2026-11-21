<?php

namespace App\Http\Controllers;

use App\Models\CuotaAlquiler;

class CuotaAlquilerController extends Controller
{
    // Listar todas las cuotas
    public function index()
    {
        $cuotas = CuotaAlquiler::with([
            'alquiler.habitacion',
            'alquiler.inquilino',
            'detallesPago',
        ])
        ->orderByDesc('fecha_vencimiento')
        ->paginate(15);

        return view('cuotas.index', compact('cuotas'));
    }

    // Ver detalle de una cuota
    public function show(CuotaAlquiler $cuota)
    {
        $cuota->load([
            'alquiler.habitacion',
            'alquiler.inquilino',
            'detallesPago.pago',
        ]);

        return view('cuotas.show', compact('cuota'));
    }
}
