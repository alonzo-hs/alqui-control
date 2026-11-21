@extends('layouts.app')

@section('title', 'Detalle del alquiler')

@section('content')

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-3">Detalle del alquiler</h4>

        <p><strong>Habitación:</strong> {{ $alquiler->habitacion->numero }}</p>
        <p><strong>Inquilino:</strong> {{ $alquiler->inquilino->nombre }}</p>
        <p><strong>DNI:</strong> {{ $alquiler->inquilino->dni }}</p>
        <p><strong>Inicio:</strong> {{ $alquiler->fecha_inicio->format('d/m/Y') }}</p>
        <p><strong>Fin:</strong> {{ $alquiler->fecha_fin?->format('d/m/Y') ?? 'Indefinido' }}</p>
        <p><strong>Mensualidad:</strong> S/ {{ $alquiler->mensualidad }}</p>

    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Cuotas generadas</h5>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Monto</th>
                        <th>Vencimiento</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($alquiler->cuotas as $cuota)
                        @php
                            $pagado = $cuota->detallesPago->sum('monto_asignado');
                            $saldo = $cuota->monto - $pagado;
                        @endphp
                        <tr>
                            <td>{{ $cuota->periodo }}</td>
                            <td>S/ {{ number_format($cuota->monto, 2) }}</td>
                            <td>{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td>S/ {{ number_format($pagado, 2) }}</td>
                            <td>S/ {{ number_format($saldo, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('alquileres.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </div>
</div>

@endsection
