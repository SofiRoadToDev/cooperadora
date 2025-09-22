<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::all();

        return Inertia('Categoria/Categoria', compact('categorias'));
    }


    public function create()
    {   $categoria = new Categoria();
        return Inertia::render('Categoria/CategoriaCreate', compact('categoria'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable|string'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('categorias.create')
                ->withErrors($validator)
                ->withInput();
        }

        Categoria::create($validator->validated());
        return redirect()
                ->route('categorias.index')
                ->with('success', 'Categoría creada correctamente');
    }


    public function show(Categoria $categoria)
    {
        //
    }


    public function edit(Categoria $categoria)
    {
        return Inertia::render('Categoria/CategoriaCreate', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable|string'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('categorias.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $categoria->update($validator->validated());

        return redirect()
                ->route('categorias.index')
                ->with('success', 'Categoría actualizada correctamente');
    }


    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()
                ->route('categorias.index')
                ->with('success', 'Categoría borrada exitosamente');
    }
}
