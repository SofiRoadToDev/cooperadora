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
        return view('conceptos.create', compact('concepto'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'importe' => 'required'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('conceptos.create')
                ->withErrors($validator)
                ->withInput();
        }

        Concepto::create($request->all());
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
        return view('conceptos.create', compact($concepto));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concepto $concepto)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'importe' => 'required'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('conceptos.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $concepto->update($request->only(['nombre', 'importe']));

        return redirect()
                ->route('conceptos.index')
                ->with('success', 'Concepto actualizado correctamente');
    }


    public function destroy(Concepto $concepto)
    {
        if(!isset($concepto)){
            return redirect()
                ->route('conceptos.index')
                ->with('error', 'concepto inexistente');
        };

        $concepto->delete();

        return redirect()
                ->route('conceptos.index')
                ->with('success', 'Concepto borrado exitosamente');
    }
}
