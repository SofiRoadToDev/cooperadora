<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ConceptoController extends Controller
{
 
    public function index()
    {
        $conceptos = Concepto::all();
        
        return Inertia('Concepto/Concepto', compact('conceptos'));
    }


    public function create()
    {   $concepto = new Concepto();
        return Inertia::render('Concepto/ConceptoCreate', compact('concepto'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'importe' => 'required|numeric'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('conceptos.create')
                ->withErrors($validator)
                ->withInput();
        }

        Concepto::create($validator->validated());
        return redirect()
                ->route('conceptos.index')
                ->with('success', 'Concepto creado correctamente');
    }


    public function show(Concepto $concepto)
    {
        //
    }


    public function edit(Concepto $concepto)
    {
        return Inertia::render('Concepto/ConceptoCreate', compact('concepto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concepto $concepto)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'importe' => 'required|numeric'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('conceptos.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $concepto->update($validator->validated());

        return redirect()
                ->route('conceptos.index')
                ->with('success', 'Concepto actualizado correctamente');
    }


    public function destroy(Concepto $concepto)
    {
        $concepto->delete();

        return redirect()
                ->route('conceptos.index')
                ->with('success', 'Concepto borrado exitosamente');
    }
}
