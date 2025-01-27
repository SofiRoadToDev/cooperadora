<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Concepto;

class ApiController extends Controller
{
        public function alumnosPorDni($dni){
            $alumno = Alumno::where('dni',$dni)->first();
            if(!$alumno){
                return response()->json(['error' => 'Alumno inexistente'], 404);
            };
            return response()->json($alumno, 200);
        }


        public function conceptoById($conceptoId){
            $concepto = Concepto::find($conceptoId);
            if(!$concepto){
                return response()->json('Concepto inexistente', 404);
            }

            return response()->json($concepto, 200);
        }
}
