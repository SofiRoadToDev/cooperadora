<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['codigo', 'nivel', 'division', 'ciclo', 'turno'];


    public function alumnos(){
        return $this->hasMany(Alumno::class, 'curso');
    }
}
