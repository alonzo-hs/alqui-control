<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuotas_alquiler', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_id')
                  ->constrained('alquileres')
                  ->restrictOnDelete();

            $table->char('periodo', 7);
            $table->decimal('monto', 10, 2);
            $table->date('fecha_vencimiento');

            $table->unique(['rental_id', 'periodo']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuotas_alquiler');
    }
};
