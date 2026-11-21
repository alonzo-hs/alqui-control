@extends('layouts.app')

@section('title', 'Detalle del inquilino')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Información del inquilino</h4>

        <p><strong>DNI:</strong> {{ $inquilino->dni }}</p>
        <p><strong>Nombre:</strong> {{ $inquilino->nombre }}</p>
        <p><strong>Teléfono:</strong> {{ $inquilino->telefono ?? 'No registrado' }}</p>

        <hr>

        <h5 class="mb-3">Historial de alquileres</h5>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Habitación</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Mensualidad</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($inquilino->alquileres as $alquiler)
                    <tr>
                        <td>{{ $alquiler->habitacion->numero }}</td>
                        <td>{{ $alquiler->fecha_inicio->format('d/m/Y') }}</td>
                        <td>
                            {{ $alquiler->fecha_fin?->format('d/m/Y') ?? 'Sin fecha' }}
                        </td>
                        <td>S/ {{ $alquiler->mensualidad }}</td>
                        <td>{{ ucfirst($alquiler->estado) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Este inquilino todavía no tiene alquileres.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('inquilinos.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </div>
</div>

@endsection
