<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngresoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        \Log::info('Request data:', $this->all());
        
        return [
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'alumno_id' => 'required|exists:alumnos,id',
            'conceptos' => 'required|array|min:1',
            'conceptos.*.id' => 'required|exists:conceptos,id',
            'conceptos.*.cantidad' => 'required|integer|min:1|max:20',
            'conceptos.*.total_concepto' => 'required|numeric|min:0.01',
            'importe_total' => 'required|numeric|min:0.01',
            'email' => 'nullable|email'
        ];
    }
}
