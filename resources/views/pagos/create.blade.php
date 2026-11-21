@extends('layouts.app')

@section('title', 'Registrar pago')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">Registrar pago</h4>

        <form action="{{ route('pagos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Seleccionar cuota</label>

                <select name="charge_id" id="charge_id"
                        class="form-select" required>

                    <option value="">Seleccione una cuota</option>

                    @foreach($cuotas as $cuota)
                        @php
                            $pagado = $cuota->detallesPago->sum('monto_asignado');
                            $saldo = max(0, $cuota->monto - $pagado);
                        @endphp

                        @if($saldo > 0)
                            <option value="{{ $cuota->id }}"
                                    data-saldo="{{ number_format($saldo, 2, '.', '') }}"
                                    @selected(old('charge_id') == $cuota->id)>
                                {{ $cuota->alquiler->inquilino->nombre }}
                                - Habitación {{ $cuota->alquiler->habitacion->numero }}
                                - {{ $cuota->periodo }}
                                - Saldo: S/ {{ number_format($saldo, 2) }}
                            </option>
                        @endif
                    @endforeach

                </select>

                @error('charge_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                Saldo pendiente:
                <strong id="saldo">Seleccione una cuota</strong>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha del pago</label>
                <input type="datetime-local" name="fecha"
                       class="form-control"
                       value="{{ old('fecha', now()->format('Y-m-d\TH:i')) }}"
                       required>
                @error('fecha')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Monto recibido (S/)</label>
                <input type="number" name="monto"
                       class="form-control"
                       min="0.01" step="0.01"
                       value="{{ old('monto') }}"
                       placeholder="Ejemplo: 200.00" required>
                @error('monto')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Método de pago</label>

                <select name="metodo" class="form-select" required>
                    <option value="">Seleccione método</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Yape">Yape</option>
                    <option value="Plin">Plin</option>
                    <option value="Transferencia">Transferencia bancaria</option>
                    <option value="Deposito">Depósito</option>
                </select>

                @error('metodo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">
                Registrar pago
            </button>

            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>
</div>

<script>
    const selectCuota = document.getElementById('charge_id');
    const saldoTexto = document.getElementById('saldo');

    function actualizarSaldo() {
        const opcion = selectCuota.selectedOptions[0];

        if (opcion && opcion.dataset.saldo) {
            saldoTexto.textContent = 'S/ ' + opcion.dataset.saldo;
        } else {
            saldoTexto.textContent = 'Seleccione una cuota';
        }
    }

    selectCuota.addEventListener('change', actualizarSaldo);
    actualizarSaldo();
</script>

@endsection
