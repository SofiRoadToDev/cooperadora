<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AlumnoController extends Controller
{

    public function index()
    {
        $alumnos = Alumno::all();
        return Inertia('Alumno', compact('alumnos'));
    }


    public function create()
    {   $cursos = Curso::all();
        $alumno = new Alumno();
        return Inertia('alumnos.create', compact('cursos', 'alumno'));
    }

    public function store(Request $request)
    {      
        $validator = Validator::make($request->all(),[
            'apellido' => 'required|max:20',
            'nombre' => 'required|max:20',
            'dni' => 'required|max:8'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('alumnos.create')
                ->withErrors($validator)
                ->withInput();
        }

        Alumno::create($request->all());
         return redirect()
            ->route('alumnos.index')
            ->with('success', 'ALumno creado exitosamente');
    }

    public function show(Alumno $alumno)
    {
        //
    }

    public function edit(Alumno $alumno)
    { 
        $cursos = Curso::all();
        return view('alumnos.create', compact('alumno', 'cursos'));
    }


    public function update(Request $request, Alumno $alumno)
    {
             $validator = Validator::make($request->all(),[
            'apellido' => 'required|max:20',
            'nombre' => 'required|max:20',
            'dni' => 'required|max:8'
        ]);

        if($validator->fails()){
            return redirect()
                ->route('alumnos.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $alumno->update($request->only(['apellido', 'nombre', 'dni']));
        
         return redirect()
            ->route('alumnos.index')
            ->with('success', 'ALumno creado exitosamente');
    }

    public function destroy(Alumno $alumno)
    {   
        if(!isset($alumno)){
           return redirect()->route('alumnos.index')->with('Error', 'Alumno no existente');
        };
         Alumno::destroy($alumno->id);
            return redirect()
                    ->route('alumnos.index')
                    ->with('success', 'Alumno borrado correctamente');
    }
}
