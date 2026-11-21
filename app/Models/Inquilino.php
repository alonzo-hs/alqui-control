<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inquilino extends Model
{
    protected $table = 'inquilinos';

    protected $fillable = [
        'dni',
        'nombre',
        'telefono',
    ];

    public function alquileres(): HasMany
    {
        return $this->hasMany(Alquiler::class, 'tenant_id');
    }
}
