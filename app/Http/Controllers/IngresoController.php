<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use App\Models\Ingreso;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class IngresoController extends Controller
{

    public function index()
    {
        $ingresos = Ingreso::orderBy('fecha', 'desc')->get();
        return Inertia('Ingreso/Ingreso', compact('ingresos'));
    }


    public function create()
    {   $conceptos = Concepto::all();
        $ingreso = new Ingreso();
        return Inertia('Ingresos/IngresoCreate', compact('conceptos', 'ingreso'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       
        $validator = Validator::make($request->all(), [
        'fecha' => 'required|date',
        'hora' => 'required|date_format:H:i',
        'alumno_id' => 'required|exists:alumnos,id',
        'conceptos' => 'required|array|min:1',
        'conceptos.*.id' => 'required|exists:conceptos,id',
        'conceptos.*.cantidad' => 'required|numeric|min:0.01',
        'conceptos.*.total_concepto' => 'required|numeric|min:0.01',
        'importe_total' => 'required|numeric|min:0.01',
        'email' => 'nullable|email'
    ]);


        if($validator->fails()){
            
            return redirect()
                    ->route('ingresos.create')
                    ->withErrors($validator->errors())
                    ->withInput();
        };

        $ingresoData = $request->only(['fecha', 'hora', 'alumno_id', 'importe_total', 'email']);
              
        $ingreso = Ingreso::create($ingresoData); // despues revisar las relaciones con concepto, que son many to many
       
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
        return view('ingresos.create', compact($ingreso));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingreso $ingreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingreso $ingreso)
    {
        //
    }
}
