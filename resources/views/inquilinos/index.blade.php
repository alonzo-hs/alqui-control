@extends('layouts.app')

@section('title', 'Inquilinos')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Inquilinos</h3>
        <p class="text-muted">Administración de inquilinos registrados</p>
    </div>

    <a href="{{ route('inquilinos.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Nuevo inquilino
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Alquileres registrados</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($inquilinos as $inquilino)
                    <tr>
                        <td>{{ $inquilino->dni }}</td>
                        <td class="fw-bold">{{ $inquilino->nombre }}</td>
                        <td>{{ $inquilino->telefono ?? 'No registrado' }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $inquilino->alquileres_count }}
                            </span>
                        </td>
                        <td class="text-center">

                            <a href="{{ route('inquilinos.show', $inquilino) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('inquilinos.edit', $inquilino) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('inquilinos.destroy', $inquilino) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este inquilino?')">
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
                            No hay inquilinos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{ $inquilinos->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
