<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Insumos Talleres', 'descripcion' => 'Materiales y herramientas para talleres educativos'],
            ['nombre' => 'Gastos de Oficina', 'descripcion' => 'Papelería, útiles y materiales de oficina'],
            ['nombre' => 'Cadetería', 'descripcion' => 'Servicios de mensajería y traslados'],
            ['nombre' => 'Reparaciones Menores', 'descripcion' => 'Mantenimiento y reparaciones del establecimiento'],
            ['nombre' => 'Imprenta', 'descripcion' => 'Servicios de impresión y fotocopiado'],
            ['nombre' => 'Concursos y Actos', 'descripcion' => 'Gastos para eventos y ceremonias escolares'],
            ['nombre' => 'Jornadas', 'descripcion' => 'Gastos para jornadas educativas y capacitaciones'],
            ['nombre' => 'Otro', 'descripcion' => 'Otros gastos diversos'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}