<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = ['fecha', 'hora', 'alumno_id', 'observaciones', 'importe_total', 'emailSent', 'impreso', 'email'];


    public function conceptos(){
        return $this->belongsToMany(Concepto::class,
         'ingreso_detalle_conceptos',
         'ingreso_id', 'concepto_id')
            ->withPivot('total_concepto', 'cantidad');
    }
    public function alumno(){
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
