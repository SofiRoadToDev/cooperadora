<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Concepto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $fechaActual = Carbon::now();
        $inicioMes = $fechaActual->copy()->startOfMonth()->format('Y-m-d');
        $finMes = $fechaActual->copy()->endOfMonth()->format('Y-m-d');

        return Inertia::render('Informes/Index', [
            'fecha_inicio_default' => $inicioMes,
            'fecha_fin_default' => $finMes
        ]);
    }

    public function getIngresosPorConcepto(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $ingresosPorConcepto = DB::table('ingreso_detalle_conceptos as idc')
            ->join('ingresos as i', 'idc.ingreso_id', '=', 'i.id')
            ->join('conceptos as c', 'idc.concepto_id', '=', 'c.id')
            ->select(
                'c.nombre as concepto_nombre',
                'c.tipo as concepto_tipo',
                DB::raw('SUM(idc.total_concepto) as total_importe'),
                DB::raw('SUM(idc.cantidad) as total_cantidad')
            )
            ->whereBetween('i.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('c.id', 'c.nombre', 'c.tipo')
            ->orderBy('total_importe', 'desc')
            ->get();

        return response()->json($ingresosPorConcepto);
    }

    public function getEgresosPorCategoria(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $egresosPorCategoria = DB::table('egresos as e')
            ->leftJoin('categorias as cat', 'e.categoria_id', '=', 'cat.id')
            ->select(
                'cat.nombre as categoria_nombre',
                'cat.descripcion as categoria_descripcion',
                DB::raw('COALESCE(cat.nombre, "Sin Categoría") as categoria_display'),
                DB::raw('SUM(e.importe) as total_importe'),
                DB::raw('COUNT(e.id) as cantidad_egresos')
            )
            ->whereBetween('e.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('cat.id', 'cat.nombre', 'cat.descripcion')
            ->orderBy('total_importe', 'desc')
            ->get();

        return response()->json($egresosPorCategoria);
    }

    public function getSaldoGeneral(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $totalIngresos = DB::table('ingresos')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('importe_total');

        $totalEgresos = DB::table('egresos')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('importe');

        $saldo = $totalIngresos - $totalEgresos;

        return response()->json([
            'total_ingresos' => $totalIngresos,
            'total_egresos' => $totalEgresos,
            'saldo' => $saldo,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ]);
    }

    public function getResumenMensual(Request $request)
    {
        $año = $request->input('año', Carbon::now()->year);

        $resumenMensual = [];

        for ($mes = 1; $mes <= 12; $mes++) {
            $fechaInicio = Carbon::createFromDate($año, $mes, 1)->startOfMonth();
            $fechaFin = Carbon::createFromDate($año, $mes, 1)->endOfMonth();

            $totalIngresos = DB::table('ingresos')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->sum('importe_total');

            $totalEgresos = DB::table('egresos')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->sum('importe');

            $resumenMensual[] = [
                'mes' => $mes,
                'mes_nombre' => $fechaInicio->format('F'),
                'total_ingresos' => $totalIngresos,
                'total_egresos' => $totalEgresos,
                'saldo' => $totalIngresos - $totalEgresos
            ];
        }

        return response()->json($resumenMensual);
    }

    public function getIngresosDetallados(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $ingresos = DB::table('ingresos as i')
            ->join('alumnos as a', 'i.alumno_id', '=', 'a.id')
            ->select(
                'i.id',
                'i.fecha',
                'i.hora',
                'i.importe_total',
                'i.observaciones',
                DB::raw('CONCAT(a.apellido, ", ", a.nombre) as alumno_nombre')
            )
            ->whereBetween('i.fecha', [$fechaInicio, $fechaFin])
            ->orderBy('i.fecha', 'desc')
            ->get();

        return response()->json($ingresos);
    }

    public function getEgresosDetallados(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $egresos = DB::table('egresos as e')
            ->leftJoin('categorias as cat', 'e.categoria_id', '=', 'cat.id')
            ->select(
                'e.id',
                'e.fecha',
                'e.hora',
                'e.concepto',
                'e.importe',
                'e.empresa',
                'e.tipo_comprobante',
                'e.numero_comprobante',
                'e.solicitante',
                'e.observaciones',
                DB::raw('COALESCE(cat.nombre, "Sin Categoría") as categoria_nombre')
            )
            ->whereBetween('e.fecha', [$fechaInicio, $fechaFin])
            ->orderBy('e.fecha', 'desc')
            ->get();

        return response()->json($egresos);
    }

    public function exportarIngresos(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $ingresos = DB::table('ingresos as i')
            ->join('alumnos as a', 'i.alumno_id', '=', 'a.id')
            ->leftJoin('ingreso_detalle_conceptos as idc', 'i.id', '=', 'idc.ingreso_id')
            ->leftJoin('conceptos as c', 'idc.concepto_id', '=', 'c.id')
            ->select(
                'i.id',
                'i.fecha',
                'i.hora',
                'i.importe_total',
                'i.observaciones',
                DB::raw('CONCAT(a.apellido, ", ", a.nombre) as alumno_nombre'),
                'a.dni',
                'c.nombre as concepto_nombre',
                'c.tipo as concepto_tipo',
                'idc.cantidad',
                'idc.total_concepto'
            )
            ->whereBetween('i.fecha', [$fechaInicio, $fechaFin])
            ->orderBy('i.fecha', 'desc')
            ->get();

        $filename = 'ingresos_' . $fechaInicio . '_' . $fechaFin . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($ingresos) {
            $file = fopen('php://output', 'w');

            // BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Headers
            fputcsv($file, [
                'ID Ingreso',
                'Fecha',
                'Hora',
                'Alumno',
                'DNI',
                'Concepto',
                'Tipo Concepto',
                'Cantidad',
                'Total Concepto',
                'Importe Total',
                'Observaciones'
            ], ';');

            // Datos
            foreach ($ingresos as $ingreso) {
                fputcsv($file, [
                    $ingreso->id,
                    Carbon::parse($ingreso->fecha)->format('d/m/Y'),
                    $ingreso->hora,
                    $ingreso->alumno_nombre,
                    $ingreso->dni,
                    $ingreso->concepto_nombre ?? '-',
                    $ingreso->concepto_tipo ?? '-',
                    $ingreso->cantidad ?? '-',
                    $ingreso->total_concepto ? number_format($ingreso->total_concepto, 2, ',', '.') : '-',
                    number_format($ingreso->importe_total, 2, ',', '.'),
                    $ingreso->observaciones ?? '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportarEgresos(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $egresos = DB::table('egresos as e')
            ->leftJoin('categorias as cat', 'e.categoria_id', '=', 'cat.id')
            ->select(
                'e.id',
                'e.fecha',
                'e.hora',
                'e.concepto',
                'e.importe',
                'e.empresa',
                'e.tipo_comprobante',
                'e.numero_comprobante',
                'e.solicitante',
                'e.observaciones',
                DB::raw('COALESCE(cat.nombre, "Sin Categoría") as categoria_nombre')
            )
            ->whereBetween('e.fecha', [$fechaInicio, $fechaFin])
            ->orderBy('e.fecha', 'desc')
            ->get();

        $filename = 'egresos_' . $fechaInicio . '_' . $fechaFin . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($egresos) {
            $file = fopen('php://output', 'w');

            // BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Headers
            fputcsv($file, [
                'ID',
                'Fecha',
                'Hora',
                'Concepto',
                'Importe',
                'Categoría',
                'Empresa',
                'Tipo Comprobante',
                'Número Comprobante',
                'Solicitante',
                'Observaciones'
            ], ';');

            // Datos
            foreach ($egresos as $egreso) {
                fputcsv($file, [
                    $egreso->id,
                    Carbon::parse($egreso->fecha)->format('d/m/Y'),
                    $egreso->hora,
                    $egreso->concepto,
                    number_format($egreso->importe, 2, ',', '.'),
                    $egreso->categoria_nombre,
                    $egreso->empresa ?? '-',
                    $egreso->tipo_comprobante,
                    $egreso->numero_comprobante ?? '-',
                    $egreso->solicitante,
                    $egreso->observaciones ?? '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportarResumen(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        // Obtener datos
        $ingresosPorConcepto = $this->getIngresosPorConcepto($request)->getData();
        $egresosPorCategoria = $this->getEgresosPorCategoria($request)->getData();
        $saldoGeneral = $this->getSaldoGeneral($request)->getData();

        $filename = 'resumen_' . $fechaInicio . '_' . $fechaFin . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($ingresosPorConcepto, $egresosPorCategoria, $saldoGeneral, $fechaInicio, $fechaFin) {
            $file = fopen('php://output', 'w');

            // BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Resumen general
            fputcsv($file, ['RESUMEN GENERAL'], ';');
            fputcsv($file, ['Período', $fechaInicio . ' al ' . $fechaFin], ';');
            fputcsv($file, ['Total Ingresos', number_format($saldoGeneral->total_ingresos, 2, ',', '.')], ';');
            fputcsv($file, ['Total Egresos', number_format($saldoGeneral->total_egresos, 2, ',', '.')], ';');
            fputcsv($file, ['Saldo', number_format($saldoGeneral->saldo, 2, ',', '.')], ';');
            fputcsv($file, [], ';'); // Línea vacía

            // Ingresos por concepto
            fputcsv($file, ['INGRESOS POR CONCEPTO'], ';');
            fputcsv($file, ['Concepto', 'Tipo', 'Cantidad', 'Total'], ';');
            foreach ($ingresosPorConcepto as $ingreso) {
                fputcsv($file, [
                    $ingreso->concepto_nombre,
                    $ingreso->concepto_tipo,
                    $ingreso->total_cantidad,
                    number_format($ingreso->total_importe, 2, ',', '.')
                ], ';');
            }
            fputcsv($file, [], ';'); // Línea vacía

            // Egresos por categoría
            fputcsv($file, ['EGRESOS POR CATEGORÍA'], ';');
            fputcsv($file, ['Categoría', 'Cantidad Egresos', 'Total'], ';');
            foreach ($egresosPorCategoria as $egreso) {
                fputcsv($file, [
                    $egreso->categoria_display,
                    $egreso->cantidad_egresos,
                    number_format($egreso->total_importe, 2, ',', '.')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}