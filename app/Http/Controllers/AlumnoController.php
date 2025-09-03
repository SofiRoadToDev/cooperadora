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
        // Eager load la relación 'curso' para evitar problemas N+1
        $alumnos = Alumno::with('curso')->get();
        return Inertia('Alumno/Alumno', compact('alumnos'));
    }


    public function create()
    {   
        $cursos = Curso::all();
        return Inertia('Alumno/AlumnoCreate', compact('cursos'));
    }

    public function store(Request $request)
    {     
        $validator = Validator::make($request->all(),[
            'apellido' => 'required|max:20',
            'nombre' => 'required|max:20',
            'dni' => 'required|max:8',
            'curso' => 'required|exists:cursos,codigo' // Validar que el curso exista por su código
        ]);

        if($validator->fails()){
            return redirect('/alumnos/create')
                ->withErrors($validator)
                ->withInput();
        }
        
       
        Alumno::create($validator->validated());
        
        return redirect('/alumnos')
            ->with('success', 'ALumno creado exitosamente');
    }

    public function show(Alumno $alumno)
    {
        //
    }

    public function edit(Alumno $alumno)
    { 
        $cursos = Curso::all();
        return Inertia('Alumno/AlumnoCreate', compact('alumno', 'cursos'));
    }


    public function update(Request $request, Alumno $alumno)
    {
             $validator = Validator::make($request->all(),[
            'apellido' => 'required|max:20',
            'nombre' => 'required|max:20',
            'dni' => 'required|max:8',
            'curso' => 'required|exists:cursos,codigo' 
            /* Validar que el curso exista 
                'nombre_del_campo' => 'exists:nombre_de_la_tabla,nombre_de_la_columna'.
                el nombre del campo es el de la base de datos y el name del form debe corresponder
                Al crear la relacion en el modelo laravel asume que existe la fk con forma tabla_id
            */
        ]);

        if($validator->fails()){
            return redirect()->back() // Redirigir a la página anterior
                ->withErrors($validator)
                ->withInput();
        }

        $alumno->update($validator->validated());
        
         return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno actualizado exitosamente');
    }

    public function destroy(Alumno $alumno)
    {   
        // El Route-Model-Binding ya se encarga de verificar si el alumno existe.
        // Si no existe, Laravel arrojará un 404 automáticamente.
        $alumno->delete();
        return redirect()
                ->route('alumnos.index')
                ->with('success', 'Alumno borrado correctamente');
    }
}
