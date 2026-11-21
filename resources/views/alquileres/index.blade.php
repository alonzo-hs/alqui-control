@extends('layouts.app')

@section('title', 'Alquileres')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Alquileres</h3>
        <p class="text-muted">Administración de contratos de alquiler</p>
    </div>

    <a href="{{ route('alquileres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo alquiler
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Habitación</th>
                    <th>Inquilino</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Mensualidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($alquileres as $alquiler)
                <tr>
                    <td>{{ $alquiler->habitacion->numero }}</td>
                    <td>{{ $alquiler->inquilino->nombre }}</td>
                    <td>{{ $alquiler->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $alquiler->fecha_fin?->format('d/m/Y') ?? 'Indefinido' }}</td>
                    <td>S/ {{ $alquiler->mensualidad }}</td>
                    <td>
                        <span class="badge {{ $alquiler->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($alquiler->estado) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('alquileres.show', $alquiler) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('alquileres.edit', $alquiler) }}"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No hay alquileres registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $alquileres->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
