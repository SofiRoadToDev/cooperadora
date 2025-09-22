<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EgresoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $egresos = Egreso::with('categoria')
                            ->where('user_id', Auth::user()->id)
                            ->get();
        return Inertia('Egreso/Egreso', compact('egresos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return Inertia('Egreso/EgresoCreate', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['tipo_comprobante'])) {
            $data['tipo_comprobante'] = null;
        }

        $validator = Validator::make($data, [
            'fecha' => 'required',
            'hora' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'concepto' => 'required',
            'importe' => 'required|numeric',
            'solicitante' => 'required',
            'empresa' => 'nullable',
            'tipo_comprobante' => 'nullable|in:ticket,factura,presupuesto,nota,firma,papel,otro',
            'numero_comprobante' => 'nullable',
            'observaciones' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('egresos.create')
                ->withErrors($validator)
                ->withInput();
        }

        Egreso::create($validator->validated());

        return redirect()
            ->route('egresos.index')
            ->with('success', 'Egreso creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Egreso $egreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Egreso $egreso)
    {
        $categorias = Categoria::all();
        return Inertia('Egreso/EgresoCreate', compact('egreso', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Egreso $egreso)
    {
        $data = $request->all();
        if (empty($data['tipo_comprobante'])) {
            $data['tipo_comprobante'] = null;
        }

        $validator = Validator::make($data, [
            'fecha' => 'required',
            'hora' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'concepto' => 'required',
            'importe' => 'required|numeric',
            'solicitante' => 'required',
            'empresa' => 'nullable',
            'tipo_comprobante' => 'nullable|in:ticket,factura,presupuesto,nota,firma,papel,otro',
            'numero_comprobante' => 'nullable',
            'observaciones' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $egreso->update($validator->validated());

        return redirect()
            ->route('egresos.index')
            ->with('success', 'Egreso actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Egreso $egreso)
    {
        $egreso->delete();

        return redirect()
            ->route('egresos.index')
            ->with('success', 'Egreso eliminado exitosamente');
    }
}
