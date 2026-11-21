@extends('layouts.app')

@section('title', 'Nuevo inquilino')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Registrar inquilino</h4>

        <form action="{{ route('inquilinos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" name="dni"
                       class="form-control"
                       maxlength="8"
                       inputmode="numeric"
                       value="{{ old('dni') }}"
                       placeholder="Ingrese 8 dígitos" required>

                @error('dni')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre"
                       class="form-control"
                       value="{{ old('nombre') }}"
                       placeholder="Nombre y apellidos" required>

                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono"
                       class="form-control"
                       maxlength="9"
                       value="{{ old('telefono') }}"
                       placeholder="Número de teléfono">

                @error('telefono')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar inquilino
            </button>

            <a href="{{ route('inquilinos.index') }}"
               class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>
</div>

@endsection
