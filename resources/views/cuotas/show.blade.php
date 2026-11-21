@extends('layouts.app')

@section('title', 'Detalle de cuota')

@section('content')

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-3">Detalle de cuota</h4>

        <p>
            <strong>Inquilino:</strong>
            {{ $cuota->alquiler->inquilino->nombre }}
        </p>

        <p>
            <strong>DNI:</strong>
            {{ $cuota->alquiler->inquilino->dni }}
        </p>

        <p>
            <strong>Habitación:</strong>
            {{ $cuota->alquiler->habitacion->numero }}
        </p>

        <p><strong>Periodo:</strong> {{ $cuota->periodo }}</p>

        <p>
            <strong>Vencimiento:</strong>
            {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
        </p>

        @php
            $pagado = $cuota->detallesPago->sum('monto_asignado');
            $saldo = max(0, $cuota->monto - $pagado);
        @endphp

        <p>
            <strong>Monto:</strong>
            S/ {{ number_format($cuota->monto, 2) }}
        </p>

        <p>
            <strong>Pagado:</strong>
            S/ {{ number_format($pagado, 2) }}
        </p>

        <h5 class="text-danger">
            Saldo pendiente: S/ {{ number_format($saldo, 2) }}
        </h5>

    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Historial de pagos</h5>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Método</th>
                        <th>Monto asignado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cuota->detallesPago as $detalle)
                    <tr>
                        <td>{{ $detalle->pago->fecha->format('d/m/Y H:i') }}</td>
                        <td>{{ $detalle->pago->metodo }}</td>
                        <td>S/ {{ number_format($detalle->monto_asignado, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            No existen pagos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('cuotas.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </div>
</div>

@endsection
