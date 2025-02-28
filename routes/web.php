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




Route::get('/alumnos', [AlumnoController::class, 'index']);

Route::get('/ingresos', [IngresoController::class, 'index']);

Route::get('/egresos', [EgresoController::class, 'index']);


Route::get('/conceptos', [ConceptoController::class, 'index']);




/*Route::resource('/ingresos', IngresoController::class)->except('/');
Route::resource('/egresos',EgresoController::class);
Route::resource('/conceptos', ConceptoController::class);
Route::resource('/alumnos', AlumnoController::class);*/

// Voy a buscar en base de dato latest para obtener el id. Solo una persona debe usar el sistema por vez.
Route::get('/mail', function (){
    $ingreso = Ingreso::latest()->first();
    
    if(!$ingreso){
        return redirect()
                ->route('ingresos.create')
                ->with('Error', 'no ha brindado un email');
    };
    Mail::to($ingreso->email)->send(new FacturaMail($ingreso));

    return redirect()
            ->route('alumnos.create')// Por si quire tambien imprimir lo volvemos al formulario
            ->with('success', 'Email enviado correctamente');
})->name('mails.factura');


Route::get('/pdf', function () {
   
    //$ingreso = Ingreso::latest('id')->first();
    $ingreso = Ingreso::find(1);
    dd($ingreso);
    if(!$ingreso){
        return redirect()
                ->route('ingresos.create')
                ->with('error', 'ingreso no encontrado');
    };

    $factura = Pdf::loadView('pdf.factura',  compact('ingreso'));

    return $factura->download();
})->name('pdfs.factura');


Route::get('/api/alumnos/{dni}', [ApiController::class, 'alumnosPorDni']);
