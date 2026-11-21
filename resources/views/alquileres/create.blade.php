@extends('layouts.app')

@section('title', 'Nuevo alquiler')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Registrar nuevo alquiler</h4>

        <form action="{{ route('alquileres.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Habitación disponible</label>
                <select name="room_id" class="form-select" required>
                    <option value="">Seleccione una habitación</option>
                    @foreach($habitaciones as $habitacion)
                        <option value="{{ $habitacion->id }}"
                            @selected(old('room_id') == $habitacion->id)>
                            Habitación {{ $habitacion->numero }} - Piso {{ $habitacion->piso }}
                        </option>
                    @endforeach
                </select>
                @error('room_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Inquilino</label>
                <select name="tenant_id" class="form-select" required>
                    <option value="">Seleccione un inquilino</option>
                    @foreach($inquilinos as $inquilino)
                        <option value="{{ $inquilino->id }}"
                            @selected(old('tenant_id') == $inquilino->id)>
                            {{ $inquilino->nombre }} - DNI: {{ $inquilino->dni }}
                        </option>
                    @endforeach
                </select>
                @error('tenant_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio"
                           class="form-control"
                           value="{{ old('fecha_inicio') }}" required>
                    @error('fecha_inicio')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de finalización</label>
                    <input type="date" name="fecha_fin"
                           class="form-control"
                           value="{{ old('fecha_fin') }}">
                    <small class="text-muted">Dejar vacío si no tiene fecha final.</small>
                    @error('fecha_fin')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mensualidad (S/)</label>
                <input type="number" name="mensualidad"
                       class="form-control"
                       min="0.01" step="0.01"
                       value="{{ old('mensualidad') }}"
                       placeholder="400.00" required>
                @error('mensualidad')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                Las cuotas mensuales se generarán automáticamente al guardar.
            </div>

            <button type="submit" class="btn btn-primary">
                Registrar alquiler
            </button>

            <a href="{{ route('alquileres.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>

    </div>
</div>

@endsection
