<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Concepto;

class ConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conceptos = [
            [
                'nombre' => 'Constancia Alumno Regular',
                'importe' => 2000.00
            ],
            [
                'nombre' => 'Formulario Anses',
                'importe' => 2000.00
            ],
            [
                'nombre' => 'Impresiones',
                'importe' => 500.00
            ],
            [
                'nombre' => 'Inscripcion',
                'importe' => 50000.00
            ],
            [
                'nombre' => 'Reincorporacion',
                'importe' => 25000.00
            ]
        ];

        foreach ($conceptos as $concepto) {
            Concepto::create($concepto);
        }
    }
}