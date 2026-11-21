<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = [
        'numero',
        'piso',
        'descripcion',
    ];

    public function alquileres(): HasMany
    {
        return $this->hasMany(Alquiler::class, 'room_id');
    }
}
