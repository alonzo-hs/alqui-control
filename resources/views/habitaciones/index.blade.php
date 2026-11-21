@extends('layouts.app')

@section('title', 'Habitaciones')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Habitaciones</h3>
        <p class="text-muted">Administración de habitaciones</p>
    </div>

    <a href="{{ route('habitaciones.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nueva habitación
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Número</th>
                        <th>Piso</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($habitaciones as $habitacion)

                    <tr>
                        <td class="fw-bold">
                            {{ $habitacion->numero }}
                        </td>

                        <td>{{ $habitacion->piso }}</td>

                        <td>{{ $habitacion->descripcion ?? 'Sin descripción' }}</td>

                        <td>
                            @if($habitacion->alquileres->contains(function ($alquiler) {
                                return $alquiler->estado === 'activo';
                            }))
                                <span class="badge bg-danger">Ocupada</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>

                        <td class="text-center">

                            <a href="{{ route('habitaciones.show', $habitacion) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('habitaciones.edit', $habitacion) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('habitaciones.destroy', $habitacion) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta habitación?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </form>

                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No hay habitaciones registradas.
                        </td>
                    </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        {{ $habitaciones->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
