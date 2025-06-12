<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\IngresoController;
use App\Mail\FacturaMail;
use App\Models\Alumno;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Models\Ingreso;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;





Route::resource('/alumnos', AlumnoController::class);

Route::resource('/ingresos', IngresoController::class);

Route::get('/api/alumnos/buscar/{dni}', [IngresoController::class, 'buscarAlumno']);

Route::get('/egresos', [EgresoController::class, 'index']);


Route::get('/conceptos', [ConceptoController::class, 'index']);




/*Route::resource('/ingresos', IngresoController::class)->except('/');
Route::resource('/egresos',EgresoController::class);
Route::resource('/conceptos', ConceptoController::class);*/

// Voy a buscar en base de dato latest para obtener el id. Solo una persona debe usar el sistema por vez.
Route::get('/mail', function (){
    $ingreso = Ingreso::with(['alumno', 'conceptos'])->latest()->first();
    
    if(!$ingreso){
        return redirect()
                ->route('ingresos.create')
                ->with('error', 'No se encontró ningún ingreso');
    }
    
    if(!$ingreso->email || !filter_var($ingreso->email, FILTER_VALIDATE_EMAIL)){
        return redirect()
                ->route('ingresos.create')
                ->with('error', 'Email no válido o no proporcionado');
    }
    
    Mail::to($ingreso->email)->send(new FacturaMail($ingreso));

    return redirect()
            ->route('alumnos.create')// Por si quire tambien imprimir lo volvemos al formulario
            ->with('success', 'Email enviado correctamente');
})->name('mails.factura');


Route::get('/pdf', function () {
    $ingreso = Ingreso::with(['alumno', 'conceptos'])->latest()->first();
    
    if(!$ingreso){
        return redirect()
                ->route('ingresos.create')
                ->with('error', 'No se encontró ningún ingreso');
    }

    $factura = Pdf::loadView('pdf.factura', compact('ingreso'));

    return $factura->download('comprobante-' . $ingreso->id . '.pdf');
})->name('pdfs.factura');


Route::get('/api/alumnos/{dni}', [ApiController::class, 'alumnosPorDni']);
