<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $fillable = [
        'fecha',
        'hora',
        'categoria_id',
        'concepto',
        'importe',
        'solicitante',
        'empresa',
        'tipo_comprobante',
        'numero_comprobante',
        'observaciones'
    ];
    
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
}
