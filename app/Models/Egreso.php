<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $fillable = [
        'fecha',
         'hora',
          'categoria',
           'importe',
            'id_concepto',
            'solicitante',
             'observaciones'];

    public function concepto(){
        return $this->hasOne(Concepto::class);
    }
}
