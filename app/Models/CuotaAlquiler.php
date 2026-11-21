<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuotaAlquiler extends Model
{
    protected $table = 'cuotas_alquiler';

    protected $fillable = [
        'rental_id',
        'periodo',
        'monto',
        'fecha_vencimiento',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha_vencimiento' => 'date',
        ];
    }

    public function alquiler(): BelongsTo
    {
        return $this->belongsTo(Alquiler::class, 'rental_id');
    }

    public function detallesPago(): HasMany
    {
        return $this->hasMany(DetallePago::class, 'charge_id');
    }
}
