@extends('layouts.app')

@section('title', 'Editar alquiler')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Editar alquiler</h4>

        <p><strong>Habitación:</strong> {{ $alquiler->habitacion->numero }}</p>
        <p><strong>Inquilino:</strong> {{ $alquiler->inquilino->nombre }}</p>

        <form action="{{ route('alquileres.update', $alquiler) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Fecha de finalización</label>
                <input type="date" name="fecha_fin"
                       class="form-control"
                       value="{{ old('fecha_fin', $alquiler->fecha_fin?->format('Y-m-d')) }}">
                @error('fecha_fin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mensualidad</label>
                <input type="number" name="mensualidad"
                       class="form-control" min="0.01" step="0.01"
                       value="{{ old('mensualidad', $alquiler->mensualidad) }}" required>
                @error('mensualidad')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">Actualizar</button>

            <a href="{{ route('alquileres.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </form>

    </div>
</div>

@endsection
