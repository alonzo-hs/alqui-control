<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                  ->constrained('habitaciones')
                  ->restrictOnDelete();

            $table->foreignId('tenant_id')
                  ->constrained('inquilinos')
                  ->restrictOnDelete();

            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('mensualidad', 10, 2);
            $table->enum('estado', ['activo', 'finalizado'])
                  ->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alquileres');
    }
};
