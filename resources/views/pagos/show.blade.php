@extends('layouts.app')

@section('title', 'Detalle del pago')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Comprobante de pago</h4>

        <p>
            <strong>Fecha:</strong>
            {{ $pago->fecha->format('d/m/Y H:i') }}
        </p>

        <p><strong>Método:</strong> {{ $pago->metodo }}</p>

        <p>
            <strong>Importe recibido:</strong>
            S/ {{ number_format($pago->monto, 2) }}
        </p>

        <hr>

        <h5>Cuotas relacionadas</h5>

        @foreach($pago->detalles as $detalle)
            <p>
                <strong>Inquilino:</strong>
                {{ $detalle->cuota->alquiler->inquilino->nombre }}
            </p>

            <p>
                <strong>Periodo:</strong>
                {{ $detalle->cuota->periodo }}
            </p>

            <p>
                <strong>Monto asignado:</strong>
                S/ {{ number_format($detalle->monto_asignado, 2) }}
            </p>
            <hr>
        @endforeach

        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </div>
</div>

@endsection
