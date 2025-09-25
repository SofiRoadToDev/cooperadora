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
        \Log::info('=== STORE INGRESO ===');
        \Log::info('Email recibido en store: ' . ($request->email ?? 'null'));

        $ingresoData = $request->only(['fecha', 'hora', 'alumno_id', 'importe_total', 'observaciones']);
        $ingresoData['user_id'] = Auth::user()->id;

        // Combinar fecha y hora en formato dateTime
        $ingresoData['hora'] = $ingresoData['fecha'] . ' ' . $ingresoData['hora'] . ':00';

        $ingreso = Ingreso::create($ingresoData);

        // Guardar email en sesión si existe
        if ($request->filled('email')) {
            session(['ingreso_email_' . $ingreso->id => $request->email]);
            \Log::info('Email guardado en sesión (store): ' . $request->email);
        }

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

        // Recuperar email de la sesión si existe
        $emailSesion = session('ingreso_email_' . $ingreso->id);

        return Inertia('Ingreso/IngresoEdit', compact('ingreso', 'conceptos', 'emailSesion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreIngresoRequest $request, Ingreso $ingreso)
    {
        \Log::info('=== UPDATE INGRESO ===');
        \Log::info('Email recibido: ' . ($request->email ?? 'null'));
        \Log::info('Email filled: ' . ($request->filled('email') ? 'true' : 'false'));

        try {
            $ingresoData = $request->only(['fecha', 'hora', 'alumno_id', 'importe_total', 'observaciones']);

            // Combinar fecha y hora en formato dateTime
            $ingresoData['hora'] = $ingresoData['fecha'] . ' ' . $ingresoData['hora'] . ':00';

            $ingreso->update($ingresoData);

            // Actualizar email en sesión si existe
            if ($request->filled('email')) {
                session(['ingreso_email_' . $ingreso->id => $request->email]);
                \Log::info('Email guardado en sesión: ' . $request->email);
            } else {
                // Si no hay email, limpiar la sesión
                session()->forget('ingreso_email_' . $ingreso->id);
            }

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
                ->route('ingresos.edit', $ingreso)
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
        \Log::info('=== ACCESO A mostrarParaImprimir ===');
       

        // Verificar que el ingreso pertenece al usuario autenticado
        if ($ingreso->user_id !== Auth::user()->id) {
            abort(403, 'No tienes permisos para acceder a este ingreso.');
        }

        // Cargar relaciones necesarias
        $ingreso->load(['alumno', 'conceptos']);

        // Recuperar email de la sesión si existe para pasarlo a la vista
        $emailSesion = session('ingreso_email_' . $ingreso->id);
         \Log::info('emailSession antes de ir a la vista impresion: ' . $emailSesion);
        return view('pdf.recibo-print', compact('ingreso', 'emailSesion'));
    }

    public function enviarEmail(Ingreso $ingreso)
    {
        \Log::info('=== INICIO enviarEmail ===');

        // Verificar que el ingreso pertenece al usuario autenticado
        if ($ingreso->user_id !== Auth::user()->id) {
            \Log::error('Acceso denegado - usuario no autorizado');
            abort(403, 'No tienes permisos para acceder a este ingreso.');
        }

        // Cargar relaciones necesarias
        $ingreso->load(['alumno', 'conceptos']);

        // Buscar email en este orden: sesión → alumno → error
        $emailSesion = session('ingreso_email_' . $ingreso->id);
        $emailAlumno = $ingreso->alumno->email ?? null;
        \Log::info('Email sesión: ' . ($emailSesion ?? 'null'));
        \Log::info('Email alumno: ' . ($emailAlumno ?? 'null'));

        $email = $emailSesion ?? $emailAlumno ?? null;
        \Log::info('Email final: ' . ($email ?? 'null'));

        if (!$email) {
            \Log::error('No se encontró email');
            return redirect()->back()
                ->withErrors(['error' => 'No se encontró una dirección de email para enviar el recibo.']);
        }

        try {
            \Log::info('Intentando enviar email a: ' . $email);

            // Enviar email
            Mail::to($email)->send(new FacturaMail($ingreso));
            \Log::info('Email enviado exitosamente');

            // Marcar como enviado
            $ingreso->update(['emailSent' => true]);
            \Log::info('Ingreso marcado como enviado');

            // Limpiar email de la sesión después de enviar exitosamente
            session()->forget('ingreso_email_' . $ingreso->id);
            \Log::info('Sesión limpiada');

            return redirect()->back()
                ->with('success', 'Recibo enviado exitosamente a ' . $email);

        } catch (\Exception $e) {
            \Log::error('Error enviando email: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withErrors(['error' => 'Error al enviar el email: ' . $e->getMessage()]);
        }
    }
}
