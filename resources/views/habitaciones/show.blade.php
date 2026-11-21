@extends('layouts.app')

@section('title', 'Detalle de habitación')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">
            Habitación {{ $habitacion->numero }}
        </h4>

        <p><strong>Piso:</strong> {{ $habitacion->piso }}</p>

        <p><strong>Descripción:</strong>
            {{ $habitacion->descripcion ?? 'Sin descripción' }}
        </p>

        <p><strong>Estado:</strong>
            @if($habitacion->alquileres->contains(function ($alquiler) {
                return $alquiler->estado === 'activo';
            }))
                <span class="badge bg-danger">Ocupada</span>
            @else
                <span class="badge bg-success">Disponible</span>
            @endif
        </p>

        <a href="{{ route('habitaciones.index') }}"
           class="btn btn-secondary">
            Volver
        </a>

    </div>
</div>

@endsection
