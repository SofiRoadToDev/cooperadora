<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $egresos = Egreso::all();
<<<<<<< HEAD
        return Inertia('/Egreso/Egreso', compact('egresos'));
=======
        return Inertia('Pages/Egresos/Index', compact('egresos'));
>>>>>>> 1ba139bfe203a2faec68059d7f328d06fa1533f9
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $egreso = new Egreso();
        return view('egresos.create', compact('egreso'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('egresos.create', compact($egreso));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Egreso $egreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Egreso $egreso)
    {
        //
    }
}
