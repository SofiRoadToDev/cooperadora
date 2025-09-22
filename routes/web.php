<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('ingresos.index');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de la aplicación principal
    Route::resource('ingresos', IngresoController::class);
    Route::resource('egresos', EgresoController::class);
    Route::resource('conceptos', ConceptoController::class);
    Route::resource('alumnos', AlumnoController::class);

    // Rutas de informes
    Route::get('/informes', [ReportController::class, 'index'])->name('informes.index');
    Route::get('/api/ingresos-por-concepto', [ReportController::class, 'ingresosPorConcepto'])->withoutMiddleware(['csrf']);
    Route::get('/api/egresos-por-categoria', [ReportController::class, 'egresosPorCategoria'])->withoutMiddleware(['csrf']);
    Route::get('/api/ingresos-detallados', [ReportController::class, 'ingresosDetallados'])->withoutMiddleware(['csrf']);
    Route::get('/api/egresos-detallados', [ReportController::class, 'egresosDetallados'])->withoutMiddleware(['csrf']);
    Route::get('/export/ingresos-concepto', [ReportController::class, 'exportIngresosPorConcepto'])->name('export.ingresos.concepto');
    Route::get('/export/egresos-categoria', [ReportController::class, 'exportEgresosPorCategoria'])->name('export.egresos.categoria');
    Route::get('/export/ingresos-detallados', [ReportController::class, 'exportIngresosDetallados'])->name('export.ingresos.detallados');
    Route::get('/export/egresos-detallados', [ReportController::class, 'exportEgresosDetallados'])->name('export.egresos.detallados');
});

require __DIR__.'/auth.php';