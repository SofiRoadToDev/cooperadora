<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = ['apellido', 'nombre', 'dni', 'curso'];
    protected $primaryKey = 'id';
    protected $table = 'alumnos';

    public function curso(){
        return $this->belongsTo(Curso::class);
    }

    public function ingresos(){
        return $this->hasMany(Ingreso::class);
    }
}
