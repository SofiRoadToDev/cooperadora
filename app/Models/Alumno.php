<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = ['apellido', 'nombre', 'dni', 'curso'];


    public function curso(){
        $this->belongsTo(Curso::class);
    }
}
