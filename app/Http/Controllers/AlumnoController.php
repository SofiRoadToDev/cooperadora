<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $cursos = Curso::all();
        return view('alumnos.create', compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       

        $validator = Validator::make($request->all(),[
            'apellido' => 'required|max:20',
            'nombre' => 'required|max:20',
            'dni' => 'required|max:8'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('alumnos.crear')
                ->withErrors($validator)
                ->withInput();
        }

        Alumno::create($request->all());
         return redirect()
            ->route('alumnos.index')
            ->with('success', 'ALumno creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        //
    }
}
