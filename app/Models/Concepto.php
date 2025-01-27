<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $fillable = ['nombre', 'importe', 'tipo'];
    protected $table = 'conceptos';


    public function ingresos(){
        return $this->belongsToMany(Ingreso::class, 'ingreso_detalle_conceptos', 'concepto_id', 'ingreso_id');
    }

    public function egresos(){
        return $this->hasMany(Egreso::class, 'id_concepto');
    }
}
