@extends('layouts.app')

@section('title', 'Control de deudas')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold">Control de deudas</h3>
    <p class="text-muted">
        Consulta los saldos pendientes de tus inquilinos.
    </p>
</div>

{{-- Resumen de deudas --}}

<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Deuda total</p>
                <h3 class="fw-bold">
                    S/ {{ number_format($totalDeuda, 2) }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Deudas vencidas</p>
                <h3 class="fw-bold text-danger">
                    S/ {{ number_format($totalVencido, 2) }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Pendientes por vencer</p>
                <h3 class="fw-bold text-warning">
                    S/ {{ number_format($totalPendiente, 2) }}
                </h3>
            </div>
        </div>
    </div>

</div>

{{-- Tabla de deudas --}}

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Inquilinos con deudas</h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Inquilino</th>
                        <th>DNI</th>
                        <th>Habitación</th>
                        <th>Periodo</th>
                        <th>Vencimiento</th>
                        <th>Monto</th>
                        <th>Pagado</th>
                        <th>Deuda</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($deudas as $item)

                    @php
                        $cuota = $item['cuota'];
                    @endphp

                    <tr>
                        <td>
                            {{ $cuota->alquiler->inquilino->nombre }}
                        </td>

                        <td>
                            {{ $cuota->alquiler->inquilino->dni }}
                        </td>

                        <td>
                            {{ $cuota->alquiler->habitacion->numero }}
                        </td>

                        <td>{{ $cuota->periodo }}</td>

                        <td>
                            {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                        </td>

                        <td>
                            S/ {{ number_format($cuota->monto, 2) }}
                        </td>

                        <td>
                            S/ {{ number_format($item['pagado'], 2) }}
                        </td>

                        <td class="fw-bold text-danger">
                            S/ {{ number_format($item['saldo'], 2) }}
                        </td>

                        <td>
                            @if($item['estado'] === 'Vencida')
                                <span class="badge bg-danger">
                                    Vencida
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    Pendiente
                                </span>
                            @endif
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="bi bi-check-circle text-success fs-3"></i>
                            <p class="mb-0">
                                No existen deudas pendientes.
                            </p>
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection
