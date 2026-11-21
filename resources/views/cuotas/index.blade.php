@extends('layouts.app')

@section('title', 'Cuotas de alquiler')

@section('content')

<h3 class="fw-bold">Cuotas de alquiler</h3>
<p class="text-muted">Control de mensualidades y vencimientos</p>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Inquilino</th>
                        <th>Habitación</th>
                        <th>Periodo</th>
                        <th>Monto</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                        <th>Detalle</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cuotas as $cuota)

                    @php
                        $pagado = $cuota->detallesPago->sum('monto_asignado');
                        $saldo = max(0, $cuota->monto - $pagado);

                        if ($saldo <= 0) {
                            $estado = 'Pagada';
                            $color = 'success';
                        } elseif ($cuota->fecha_vencimiento->isPast()) {
                            $estado = 'Vencida';
                            $color = 'danger';
                        } else {
                            $estado = 'Pendiente';
                            $color = 'warning';
                        }
                    @endphp

                    <tr>
                        <td>
                            {{ $cuota->alquiler->inquilino->nombre }}
                        </td>

                        <td>
                            {{ $cuota->alquiler->habitacion->numero }}
                        </td>

                        <td>{{ $cuota->periodo }}</td>

                        <td>S/ {{ number_format($cuota->monto, 2) }}</td>

                        <td>S/ {{ number_format($pagado, 2) }}</td>

                        <td class="fw-bold">
                            S/ {{ number_format($saldo, 2) }}
                        </td>

                        <td>
                            {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                        </td>

                        <td>
                            <span class="badge bg-{{ $color }}">
                                {{ $estado }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('cuotas.show', $cuota) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No hay cuotas registradas.
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        {{ $cuotas->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
