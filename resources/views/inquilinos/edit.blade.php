@extends('layouts.app')

@section('title', 'Editar inquilino')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Editar inquilino</h4>

        <form action="{{ route('inquilinos.update', $inquilino) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" name="dni"
                       class="form-control"
                       maxlength="8"
                       value="{{ old('dni', $inquilino->dni) }}" required>
                @error('dni')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre"
                       class="form-control"
                       value="{{ old('nombre', $inquilino->nombre) }}" required>
                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono"
                       class="form-control"
                       value="{{ old('telefono', $inquilino->telefono) }}">
            </div>

            <button type="submit" class="btn btn-primary">
                Actualizar
            </button>

            <a href="{{ route('inquilinos.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>

    </div>
</div>

@endsection
