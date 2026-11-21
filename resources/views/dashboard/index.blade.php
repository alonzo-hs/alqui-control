@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-muted">Resumen general de AlquiControl</p>
</div>

{{-- Indicadores principales --}}

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-building fs-3 text-primary"></i>
                <p class="text-muted mb-1 mt-2">Habitaciones</p>
                <h3 class="fw-bold">{{ $totalHabitaciones }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-door-open fs-3 text-success"></i>
                <p class="text-muted mb-1 mt-2">Ocupadas</p>
                <h3 class="fw-bold">{{ $habitacionesOcupadas }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-door-closed fs-3 text-warning"></i>
                <p class="text-muted mb-1 mt-2">Disponibles</p>
                <h3 class="fw-bold">{{ $habitacionesDisponibles }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-people fs-3 text-info"></i>
                <p class="text-muted mb-1 mt-2">Inquilinos</p>
                <h3 class="fw-bold">{{ $totalInquilinos }}</h3>
            </div>
        </div>
    </div>

</div>

{{-- Resumen financiero --}}

<div class="row g-3 mb-4">

    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Ingresos de este mes</p>
                <h3 class="fw-bold text-success">
                    S/ {{ number_format($ingresosMes, 2) }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Deudas pendientes</p>
                <h3 class="fw-bold text-danger">
                    S/ {{ number_format($deudaTotal, 2) }}
                </h3>
            </div>
        </div>
    </div>

</div>

{{-- Gráfico de ingresos --}}

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">Ingresos de los últimos 6 meses</h5>

        <canvas id="graficoIngresos" height="100"></canvas>

    </div>
</div>

{{-- Últimos pagos --}}

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">Últimos pagos registrados</h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Inquilino</th>
                        <th>Método</th>
                        <th>Monto</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ultimosPagos as $pago)

                    <tr>
                        <td>
                            {{ $pago->fecha->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $pago->detalles->first()?->cuota?->alquiler?->inquilino?->nombre ?? 'Sin asignar' }}
                        </td>

                        <td>{{ $pago->metodo }}</td>

                        <td class="fw-bold text-success">
                            S/ {{ number_format($pago->monto, 2) }}
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No hay pagos registrados.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const periodos = @json($ingresosMensuales->pluck('periodo'));
    const ingresos = @json($ingresosMensuales->pluck('total'));

    new Chart(document.getElementById('graficoIngresos'), {
        type: 'bar',

        data: {
            labels: periodos,

            datasets: [{
                label: 'Ingresos (S/)',
                data: ingresos,
                borderWidth: 1,
                borderRadius: 6
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true,

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
