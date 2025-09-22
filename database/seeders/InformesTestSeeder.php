<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Concepto;
use App\Models\Categoria;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Curso;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InformesTestSeeder extends Seeder
{
    public function run(): void
    {
        // Crear cursos necesarios primero
        $cursos = [
            ['codigo' => '1A', 'nivel' => 1, 'division' => 1, 'ciclo' => 'Primario', 'turno' => 'Mañana'],
            ['codigo' => '1B', 'nivel' => 1, 'division' => 2, 'ciclo' => 'Primario', 'turno' => 'Tarde'],
            ['codigo' => '2A', 'nivel' => 2, 'division' => 1, 'ciclo' => 'Primario', 'turno' => 'Mañana'],
            ['codigo' => '2B', 'nivel' => 2, 'division' => 2, 'ciclo' => 'Primario', 'turno' => 'Tarde'],
            ['codigo' => '3A', 'nivel' => 3, 'division' => 1, 'ciclo' => 'Primario', 'turno' => 'Mañana'],
        ];

        foreach ($cursos as $cursoData) {
            Curso::firstOrCreate(
                ['codigo' => $cursoData['codigo']],
                $cursoData
            );
        }

        // Crear algunos alumnos de prueba
        $alumnos = [
            ['nombre' => 'Juan Carlos', 'apellido' => 'González', 'dni' => '12345678', 'curso' => '1A'],
            ['nombre' => 'María Elena', 'apellido' => 'Rodríguez', 'dni' => '23456789', 'curso' => '1B'],
            ['nombre' => 'Pedro Luis', 'apellido' => 'Martínez', 'dni' => '34567890', 'curso' => '2A'],
            ['nombre' => 'Ana Sofia', 'apellido' => 'López', 'dni' => '45678901', 'curso' => '2B'],
            ['nombre' => 'Carlos Alberto', 'apellido' => 'Fernández', 'dni' => '56789012', 'curso' => '3A'],
        ];

        foreach ($alumnos as $alumnoData) {
            Alumno::firstOrCreate(
                ['dni' => $alumnoData['dni']],
                $alumnoData
            );
        }

        // Crear conceptos de prueba (sin campo tipo, fue eliminado según migración)
        $conceptos = [
            ['nombre' => 'Cuota Mensual', 'importe' => 5000.00],
            ['nombre' => 'Material Didáctico', 'importe' => 2500.00],
            ['nombre' => 'Excursión Educativa', 'importe' => 8000.00],
            ['nombre' => 'Seguro Escolar', 'importe' => 1500.00],
            ['nombre' => 'Acto de Fin de Año', 'importe' => 3000.00],
            ['nombre' => 'Uniforme Escolar', 'importe' => 4500.00],
        ];

        foreach ($conceptos as $conceptoData) {
            Concepto::firstOrCreate(
                ['nombre' => $conceptoData['nombre']],
                $conceptoData
            );
        }

        // Crear categorías para egresos
        $categorias = [
            ['nombre' => 'Mantenimiento', 'descripcion' => 'Gastos de mantenimiento del edificio'],
            ['nombre' => 'Material Educativo', 'descripcion' => 'Compra de material didáctico y libros'],
            ['nombre' => 'Servicios', 'descripcion' => 'Servicios básicos (luz, agua, gas)'],
            ['nombre' => 'Eventos', 'descripcion' => 'Gastos para eventos y actividades escolares'],
            ['nombre' => 'Administrativo', 'descripcion' => 'Gastos administrativos y de oficina'],
        ];

        foreach ($categorias as $categoriaData) {
            Categoria::firstOrCreate(
                ['nombre' => $categoriaData['nombre']],
                $categoriaData
            );
        }

        // Obtener los registros creados
        $alumnosCreados = Alumno::all();
        $conceptosCreados = Concepto::all();
        $categoriasCreadas = Categoria::all();

        // Crear ingresos de prueba para los últimos 3 meses
        $fechasIngresos = [];
        for ($i = 0; $i < 90; $i++) {
            $fechasIngresos[] = Carbon::now()->subDays($i);
        }

        // Crear 25 ingresos distribuidos en los últimos 3 meses
        for ($i = 0; $i < 25; $i++) {
            $fecha = $fechasIngresos[array_rand($fechasIngresos)];
            $alumno = $alumnosCreados->random();

            // Seleccionar 1-3 conceptos aleatorios
            $conceptosParaIngreso = $conceptosCreados->random(rand(1, 3));
            $importeTotal = 0;

            $ingreso = Ingreso::create([
                'fecha' => $fecha->format('Y-m-d'),
                'hora' => $fecha->format('H:i:s'),
                'alumno_id' => $alumno->id,
                'observaciones' => $i % 4 == 0 ? 'Pago en efectivo' : null,
                'importe_total' => 0, // Se calculará después
                'emailSent' => false,
                'impreso' => false,
                'email' => $i % 3 == 0 ? 'test@email.com' : null,
            ]);

            // Crear las relaciones con conceptos
            foreach ($conceptosParaIngreso as $concepto) {
                $cantidad = rand(1, 2);
                $totalConcepto = $concepto->importe * $cantidad;
                $importeTotal += $totalConcepto;

                DB::table('ingreso_detalle_conceptos')->insert([
                    'ingreso_id' => $ingreso->id,
                    'concepto_id' => $concepto->id,
                    'cantidad' => $cantidad,
                    'total_concepto' => $totalConcepto,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Actualizar el importe total del ingreso
            $ingreso->update(['importe_total' => $importeTotal]);
        }

        // Crear egresos de prueba
        $tiposComprobante = ['ticket', 'factura', 'presupuesto', 'nota', 'firma', 'papel', 'otro'];
        $empresas = ['Ferretería del Centro', 'Librería Escolar', 'Edenor', 'Aysa', 'Metrogas', 'Imprenta López', null];
        $solicitantes = ['Director', 'Secretario', 'Tesorero', 'Cooperadora'];

        $egresosData = [
            ['concepto' => 'Reparación de ventanas', 'categoria' => 'Mantenimiento', 'importe_min' => 5000, 'importe_max' => 15000],
            ['concepto' => 'Pintura del aula', 'categoria' => 'Mantenimiento', 'importe_min' => 8000, 'importe_max' => 20000],
            ['concepto' => 'Compra de libros', 'categoria' => 'Material Educativo', 'importe_min' => 3000, 'importe_max' => 12000],
            ['concepto' => 'Pizarrones nuevos', 'categoria' => 'Material Educativo', 'importe_min' => 6000, 'importe_max' => 18000],
            ['concepto' => 'Factura de luz', 'categoria' => 'Servicios', 'importe_min' => 4000, 'importe_max' => 8000],
            ['concepto' => 'Factura de agua', 'categoria' => 'Servicios', 'importe_min' => 2000, 'importe_max' => 4000],
            ['concepto' => 'Decoración acto', 'categoria' => 'Eventos', 'importe_min' => 2500, 'importe_max' => 6000],
            ['concepto' => 'Refrigerio evento', 'categoria' => 'Eventos', 'importe_min' => 4000, 'importe_max' => 10000],
            ['concepto' => 'Papelería oficina', 'categoria' => 'Administrativo', 'importe_min' => 1500, 'importe_max' => 4000],
            ['concepto' => 'Impresiones', 'categoria' => 'Administrativo', 'importe_min' => 800, 'importe_max' => 2500],
        ];

        // Crear fechas para egresos (últimos 3 meses)
        $fechasEgresos = [];
        for ($i = 0; $i < 90; $i++) {
            $fechasEgresos[] = Carbon::now()->subDays($i);
        }

        // Crear 20 egresos
        for ($i = 0; $i < 20; $i++) {
            $fecha = $fechasEgresos[array_rand($fechasEgresos)];
            $egresoData = $egresosData[array_rand($egresosData)];

            $categoria = $categoriasCreadas->firstWhere('nombre', $egresoData['categoria']);
            $importe = rand($egresoData['importe_min'], $egresoData['importe_max']);

            Egreso::create([
                'fecha' => $fecha->format('Y-m-d'),
                'hora' => $fecha->format('H:i:s'),
                'categoria_id' => $categoria ? $categoria->id : null,
                'concepto' => $egresoData['concepto'],
                'importe' => $importe,
                'empresa' => $empresas[array_rand($empresas)],
                'tipo_comprobante' => $tiposComprobante[array_rand($tiposComprobante)],
                'numero_comprobante' => $i % 3 == 0 ? 'FC-' . str_pad($i + 1000, 6, '0', STR_PAD_LEFT) : null,
                'solicitante' => $solicitantes[array_rand($solicitantes)],
                'observaciones' => $i % 5 == 0 ? 'Gasto urgente aprobado por directorio' : null,
            ]);
        }

        $this->command->info('✅ Datos de prueba creados exitosamente:');
        $this->command->info('   • 5 cursos');
        $this->command->info('   • ' . $alumnosCreados->count() . ' alumnos');
        $this->command->info('   • ' . $conceptosCreados->count() . ' conceptos');
        $this->command->info('   • ' . $categoriasCreadas->count() . ' categorías');
        $this->command->info('   • 25 ingresos con conceptos asociados');
        $this->command->info('   • 20 egresos con categorías');
        $this->command->info('   • Datos distribuidos en los últimos 3 meses');
    }
}