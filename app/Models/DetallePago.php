<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePago extends Model
{
    protected $table = 'detalle_pagos';

    protected $fillable = [
        'payment_id',
        'charge_id',
        'monto_asignado',
    ];

    protected function casts(): array
    {
        return [
            'monto_asignado' => 'decimal:2',
        ];
    }

    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class, 'payment_id');
    }

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(CuotaAlquiler::class, 'charge_id');
    }
}
