@extends('layouts.app')

@section('title', 'Nueva habitación')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Registrar habitación</h4>

        <form action="{{ route('habitaciones.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Número de habitación</label>
                <input type="text" name="numero"
                       class="form-control"
                       value="{{ old('numero') }}"
                       placeholder="Ejemplo: 01" required>
                @error('numero')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Piso</label>
                <input type="number" name="piso"
                       class="form-control"
                       value="{{ old('piso', 1) }}"
                       min="1" required>
                @error('piso')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion"
                          class="form-control"
                          rows="3">{{ old('descripcion') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar habitación
            </button>

            <a href="{{ route('habitaciones.index') }}"
               class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>
</div>

@endsection
