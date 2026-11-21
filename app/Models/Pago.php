<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'fecha',
        'monto',
        'metodo',
        'usuario_registrador',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'monto' => 'decimal:2',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_registrador');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePago::class, 'payment_id');
    }
}
