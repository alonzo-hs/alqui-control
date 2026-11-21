@extends('layouts.app')

@section('title', 'Pagos')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Pagos recibidos</h3>
        <p class="text-muted">Historial de ingresos por alquiler</p>
    </div>

    <a href="{{ route('pagos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Registrar pago
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Inquilino</th>
                    <th>Método</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pagos as $pago)
                <tr>
                    <td>{{ $pago->fecha->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $pago->detalles->first()?->cuota?->alquiler?->inquilino?->nombre ?? 'Sin asignar' }}
                    </td>
                    <td>{{ $pago->metodo }}</td>
                    <td class="fw-bold">
                        S/ {{ number_format($pago->monto, 2) }}
                    </td>
                    <td>
                        <a href="{{ route('pagos.show', $pago) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No hay pagos registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $pagos->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
