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
        $conceptos = Concepto::all();
        $ingreso->load('conceptos');
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
}
