<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['codigo', 'nivel', 'division', 'ciclo', 'turno'];
    
    // Agregar el campo virtual al array de atributos serializables
    protected $appends = ['nombre'];


    public function alumnos(){
        return $this->hasMany(Alumno::class, 'curso');
    }
    
    // Accessor para crear un campo 'nombre' virtual
    public function getNombreAttribute()
    {
        return "{$this->nivel}° {$this->division}° - {$this->ciclo} - {$this->turno}";
    }
}
