<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
        'observaciones',
        'user_id'
    ];

    protected static function booted()
    {
        static::creating(function ($egreso) {
            if (Auth::check() && Auth::id()) {
                $egreso->user_id = Auth::id();
            }
        });
    }
    
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
