<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Ingreso extends Model
{
    protected $fillable = ['fecha', 'hora', 'alumno_id', 'observaciones', 'importe_total', 'emailSent', 'impreso', 'user_id'];


    public function conceptos(){
        return $this->belongsToMany(Concepto::class,
         'ingreso_detalle_conceptos',
         'ingreso_id', 'concepto_id')
            ->withPivot('total_concepto', 'cantidad');
    }
    public function alumno(){
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
