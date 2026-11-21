<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Inquilino;
use App\Models\Alquiler;
use App\Models\Pago;
use App\Models\CuotaAlquiler;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Habitaciones
        $totalHabitaciones = Habitacion::count();

        $habitacionesOcupadas = Alquiler::where('estado', 'activo')
            ->distinct()
            ->count('room_id');

        $habitacionesDisponibles = max(
            0,
            $totalHabitaciones - $habitacionesOcupadas
        );

        // Inquilinos
        $totalInquilinos = Inquilino::count();

        // Ingresos del mes
        $ingresosMes = Pago::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('monto');

        // Deudas pendientes
        $cuotas = CuotaAlquiler::with('detallesPago')->get();

        $deudaTotal = $cuotas->sum(function ($cuota) {
            $pagado = $cuota->detallesPago->sum('monto_asignado');

            return max(0, $cuota->monto - $pagado);
        });

        // Últimos pagos
        $ultimosPagos = Pago::with([
            'detalles.cuota.alquiler.inquilino'
        ])
        ->latest('fecha')
        ->take(5)
        ->get();

        // Ingresos de los últimos 6 meses
        $ingresosMensuales = Pago::select(
                DB::raw("DATE_FORMAT(fecha, '%Y-%m') as periodo"),
                DB::raw('SUM(monto) as total')
            )
            ->where('fecha', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        return view('dashboard.index', compact(
            'totalHabitaciones',
            'habitacionesOcupadas',
            'habitacionesDisponibles',
            'totalInquilinos',
            'ingresosMes',
            'deudaTotal',
            'ultimosPagos',
            'ingresosMensuales'
        ));
    }
}
