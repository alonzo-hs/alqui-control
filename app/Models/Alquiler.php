<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alquiler extends Model
{
    protected $table = 'alquileres';

    protected $fillable = [
        'room_id',
        'tenant_id',
        'fecha_inicio',
        'fecha_fin',
        'mensualidad',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'mensualidad' => 'decimal:2',
        ];
    }

    public function habitacion(): BelongsTo
    {
        return $this->belongsTo(Habitacion::class, 'room_id');
    }

    public function inquilino(): BelongsTo
    {
        return $this->belongsTo(Inquilino::class, 'tenant_id');
    }

    public function cuotas(): HasMany
    {
        return $this->hasMany(CuotaAlquiler::class, 'rental_id');
    }
}
