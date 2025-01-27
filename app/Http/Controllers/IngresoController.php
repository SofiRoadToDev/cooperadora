<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngresoController extends Controller
{

    public function index()
    {
        $ingresos = Ingreso::orderBy('fecha', 'desc')->get();
        return view('ingresos.index', compact('ingresos'));
    }


    public function create()
    {   $conceptos = Concepto::all();
        $ingreso = new Ingreso();
        return view('ingresos.create', compact('conceptos', 'ingreso'));
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
            'conceptos' => 'required|array',
            'conceptos.*id' => 'required|exists:concepto,id',
            'importe_total' => 'required|numeric|min:1'
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
