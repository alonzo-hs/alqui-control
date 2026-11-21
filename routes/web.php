<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\InquilinoController;
use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\CuotaAlquilerController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\DeudaController;   
use App\Http\Controllers\DashboardController;

/* Route::get('/', function () {
    return redirect()->route('habitaciones.index');
});
 */
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::resource('habitaciones', HabitacionController::class);

Route::resource('inquilinos', InquilinoController::class);

Route::resource('alquileres', AlquilerController::class)
    ->parameters(['alquileres' => 'alquiler']);

Route::get('/cuotas', [CuotaAlquilerController::class, 'index'])
    ->name('cuotas.index');
Route::get('/cuotas/{cuota}', [CuotaAlquilerController::class, 'show'])
    ->name('cuotas.show');

Route::get('/pagos', [PagoController::class, 'index'])
    ->name('pagos.index');
Route::get('/pagos/create', [PagoController::class, 'create'])
    ->name('pagos.create');
Route::post('/pagos', [PagoController::class, 'store'])
    ->name('pagos.store');
Route::get('/pagos/{pago}', [PagoController::class, 'show'])
    ->name('pagos.show');

Route::get('/deudas', [DeudaController::class, 'index'])
    ->name('deudas.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');