<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\CategoriaController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de la aplicación principal
    Route::get('/ingresos/{ingreso}/pdf', [IngresoController::class, 'generarPDF'])->name('pdfs.factura');
    Route::get('/ingresos/{ingreso}/print', [IngresoController::class, 'mostrarParaImprimir'])->name('ingresos.print');
    Route::get('/ingresos/{ingreso}/email', [IngresoController::class, 'enviarEmail'])->name('mails.factura');
    Route::resource('ingresos', IngresoController::class);
    Route::resource('egresos', EgresoController::class);
    Route::resource('conceptos', ConceptoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('alumnos', AlumnoController::class);


    Route::get('/test', function () {
        return view('pdf.recibo', ['ingreso' => \App\Models\Ingreso::find(1)]);
    });

    // Rutas de informes
    Route::get('/informes', [ReportController::class, 'index'])->name('informes.index');
    Route::get('/api/ingresos-por-concepto', [ReportController::class, 'getIngresosPorConcepto'])->withoutMiddleware(['csrf']);
    Route::get('/api/egresos-por-categoria', [ReportController::class, 'getEgresosPorCategoria'])->withoutMiddleware(['csrf']);
    Route::get('/api/ingresos-detallados', [ReportController::class, 'getIngresosDetallados'])->withoutMiddleware(['csrf']);
    Route::get('/api/egresos-detallados', [ReportController::class, 'getEgresosDetallados'])->withoutMiddleware(['csrf']);
    Route::get('/api/saldo-general', [ReportController::class, 'getSaldoGeneral'])->withoutMiddleware(['csrf']);
    Route::get('/api/resumen', [ReportController::class, 'getResumen'])->withoutMiddleware(['csrf']);
    Route::get('/informes/exportar-ingresos', [ReportController::class, 'exportarIngresos'])->name('informes.exportar.ingresos');
    Route::get('/informes/exportar-egresos', [ReportController::class, 'exportarEgresos'])->name('informes.exportar.egresos');
    Route::get('/informes/exportar-resumen', [ReportController::class, 'exportarResumen'])->name('informes.exportar.resumen');
});

require __DIR__.'/auth.php';