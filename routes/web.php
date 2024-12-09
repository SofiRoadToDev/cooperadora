<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\IngresoController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});


Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
Route::get('/alumnos/create', [AlumnoController::class, 'create'])->name(name: 'alumnos.crear');
Route::post('/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');


Route::get('/ingresos',[IngresoController::class, 'index'])->name('ingresos.index');
Route::get('/ingresos/create',[IngresoController::class, 'create'])->name('ingresos.create');
Route::post('/ingresos',[IngresoController::class, 'create'])->name('ingresos.store');

