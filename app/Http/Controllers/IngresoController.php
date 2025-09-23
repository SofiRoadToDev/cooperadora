<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use App\Models\Ingreso;
use App\Models\Alumno;
use App\Http\Requests\StoreIngresoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaMail;

class IngresoController extends Controller
{

    public function index()
    {
        // Usar with() para cargar relaciones como en edit()

        $ingresos = Ingreso::with(['alumno', 'conceptos'])
                            ->where('user_id', Auth::user()->id)
                          ->orderBy('fecha', 'desc')
                          ->get();

        return Inertia('Ingreso/Ingreso', ['ingresos' => $ingresos]);
    }


    public function create()
    {   $conceptos = Concepto::all();
        $ingreso = new Ingreso();
        return Inertia('Ingreso/IngresoCreate', compact('conceptos', 'ingreso'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngresoRequest $request)
    {
        $ingresoData = $request->only(['fecha', 'hora', 'alumno_id', 'importe_total', 'email', 'observaciones']);
        $ingresoData['user_id'] = Auth::user()->id;

        $ingreso = Ingreso::create($ingresoData); 
        $conceptos = [];
        foreach ($request->input('conceptos') as $concepto) {
            $conceptos[$concepto['id']] = [
                'cantidad' => $concepto['cantidad'],
                'total_concepto' => $concepto['total_concepto'],
            ];
        }

        $ingreso->conceptos()->attach($conceptos);

        return redirect()
        ->route('ingresos.create')
        ->with('success', 'Ingreso creado exitosamente con conceptos asociados.');
    }

    
    public function buscarAlumno($dni)
{
    $alumno = Alumno::where('dni', $dni)->first();
    
    if ($alumno) {
        return response()->json([
            'id' => $alumno->id,
            'nombre' => $alumno->nombre,
            'apellido' => $alumno->apellido,
            'email' => $alumno->email
        ]);
    }
    
    return response()->json(null, 404);
}
    /**
     * Display the specified resource.
     */
    public function show(Ingreso $ingreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingreso $ingreso)
    {
        // Verificar que el ingreso pertenece al usuario autenticado
        if ($ingreso->user_id !== Auth::user()->id) {
            abort(403, 'No tienes permisos para editar este ingreso.');
        }

        $conceptos = Concepto::all();
        $ingreso->load('conceptos');
        $ingreso->load('alumno');
        return Inertia('Ingreso/IngresoEdit', compact('ingreso', 'conceptos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreIngresoRequest $request, Ingreso $ingreso)
    {
        try {
            $ingresoData = $request->only(['fecha', 'hora', 'alumno_id', 'importe_total', 'email', 'observaciones']);

            $ingreso->update($ingresoData);

            // Detach existing conceptos and attach new ones
            $ingreso->conceptos()->detach();

            $conceptos = [];
            foreach ($request->input('conceptos') as $concepto) {
                $conceptos[$concepto['id']] = [
                    'cantidad' => $concepto['cantidad'],
                    'total_concepto' => $concepto['total_concepto'],
                ];
            }

            $ingreso->conceptos()->attach($conceptos);

            return redirect()
                ->route('ingresos.index')
                ->with('success', 'Ingreso actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar el ingreso: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingreso $ingreso)
    {
        try {
            // Detach conceptos before deleting
            $ingreso->conceptos()->detach();

            $ingreso->delete();

            return redirect()
                ->route('ingresos.index')
                ->with('success', 'Ingreso eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar el ingreso: ' . $e->getMessage()]);
        }
    }

    public function generarPDF(Ingreso $ingreso)
    {
        try {
            // Verificar que el ingreso pertenece al usuario autenticado
            if ($ingreso->user_id !== Auth::user()->id) {
                abort(403, 'No tienes permisos para acceder a este ingreso.');
            }

            // Cargar relaciones necesarias
            $ingreso->load(['alumno', 'conceptos']);

            // Log para debugging
            \Log::info('Generando PDF para ingreso: ' . $ingreso->id);
            \Log::info('Alumno: ' . ($ingreso->alumno ? $ingreso->alumno->nombre : 'Sin alumno'));
            \Log::info('Conceptos: ' . $ingreso->conceptos->count());

            // Generar PDF usando la vista de email
            $pdf = \PDF::loadView('pdf.recibo', ['ingreso' => $ingreso]);

            $filename = 'recibo_' . str_pad($ingreso->id, 6, '0', STR_PAD_LEFT) . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Error generando PDF: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Error al generar PDF: ' . $e->getMessage()]);
        }
    }

    public function mostrarParaImprimir(Ingreso $ingreso)
    {
        // Verificar que el ingreso pertenece al usuario autenticado
        if ($ingreso->user_id !== Auth::user()->id) {
            abort(403, 'No tienes permisos para acceder a este ingreso.');
        }

        // Cargar relaciones necesarias
        $ingreso->load(['alumno', 'conceptos']);

        return view('pdf.recibo-print', compact('ingreso'));
    }

    public function enviarEmail(Ingreso $ingreso)
    {
        // Verificar que el ingreso pertenece al usuario autenticado
        if ($ingreso->user_id !== Auth::user()->id) {
            abort(403, 'No tienes permisos para acceder a este ingreso.');
        }

        // Cargar relaciones necesarias
        $ingreso->load(['alumno', 'conceptos']);

        // Verificar que hay un email para enviar
        $email = $ingreso->email ?? $ingreso->alumno->email ?? null;

        if (!$email) {
            return redirect()->back()
                ->withErrors(['error' => 'No se encontró una dirección de email para enviar el recibo.']);
        }

        try {
            // Enviar email
            Mail::to($email)->send(new FacturaMail($ingreso));

            // Marcar como enviado
            $ingreso->update(['emailSent' => true]);

            return redirect()->back()
                ->with('success', 'Recibo enviado exitosamente a ' . $email);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al enviar el email: ' . $e->getMessage()]);
        }
    }
}
