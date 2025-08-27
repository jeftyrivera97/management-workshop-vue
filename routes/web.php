<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PintadoController;


Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');


Route::resource('ingreso', IngresoController::class)->middleware(['auth', 'verified']);
Route::resource('gasto', GastoController::class)->middleware(['auth', 'verified']);
Route::resource('planilla', PlanillaController::class)->middleware(['auth', 'verified']);
Route::resource('compra', CompraController::class)->middleware(['auth', 'verified']);
Route::resource('pintado', PintadoController::class)->middleware(['auth', 'verified']);


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
