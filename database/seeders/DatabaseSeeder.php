<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Curso;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $alumnos = [
            ['nombre' => 'Juan ', 'apellido' => 'Perez', 'dni' => 21456987],
            ['nombre' => 'Vanesa ', 'apellido' => 'Lopez', 'dni' => 78456321],
        ];

        $cursos = [
            ['codigo'=> '11cbt', 'nivel' => 1, 'division' => 1, 'ciclo' => 'basico', 'turno' => 'tarde'],
            ['codigo'=> '12cbt', 'nivel' => 1, 'division' => 2, 'ciclo' => 'basico', 'turno' => 'tarde'],
            ['codigo'=> '13cbt', 'nivel' => 1, 'division' => 3, 'ciclo' => 'basico', 'turno' => 'tarde'],
        ];
 
        foreach ($cursos as $curso) {
            Curso::updateOrCreate(['codigo' => $curso['codigo']], $curso);
        }
        
        $this->call(CategoriaSeeder::class);
    }
}
