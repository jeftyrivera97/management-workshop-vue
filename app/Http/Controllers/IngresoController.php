<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\IngresoCategoria;
use Inertia\Inertia;
use Illuminate\Support\Arr;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modulo = "Ingresos";
        $chartLabel = "Ingresos del Mes";
        $mes = now()->format('F');
        $numMes = now()->format('m');
        $mes = $this->obtenerMes($numMes);
        $year = now()->format('Y'); // Cambiar 'y' por 'Y' para año completo

        if ($numMes == '01') {
            $numMesA = '12';
            $yearA = $year - 1;
        } else {
            $numMesA = str_pad($numMes - 1, 2, '0', STR_PAD_LEFT);
            $yearA = $year;
        }

        // Remover esta línea que hardcodea enero
        // $numMes = '01';
        
        $fecha_inicial = "$year-$numMes-01";
        $fecha_final = "$year-$numMes-" . now()->format('t'); // Usar 't' para último día del mes actual


        $enero = Ingreso::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-01-31")->sum('total');
        $febrero = Ingreso::where('fecha', '>=', "$year-02-01")->where('fecha', '<=', "$year-02-28")->sum('total'); // Corregido
        $marzo = Ingreso::where('fecha', '>=', "$year-03-01")->where('fecha', '<=', "$year-03-31")->sum('total');
        $abril = Ingreso::where('fecha', '>=', "$year-04-01")->where('fecha', '<=', "$year-04-30")->sum('total'); // Corregido
        $mayo = Ingreso::where('fecha', '>=', "$year-05-01")->where('fecha', '<=', "$year-05-31")->sum('total');
        $junio = Ingreso::where('fecha', '>=', "$year-06-01")->where('fecha', '<=', "$year-06-30")->sum('total'); // Corregido
        $julio = Ingreso::where('fecha', '>=', "$year-07-01")->where('fecha', '<=',  "$year-07-31")->sum('total');
        $agosto = Ingreso::where('fecha', '>=', "$year-08-01")->where('fecha', '<=', "$year-08-31")->sum('total');
        $septiembre = Ingreso::where('fecha', '>=', "$year-09-01")->where('fecha', '<=', "$year-09-30")->sum('total'); // Corregido
        $octubre = Ingreso::where('fecha', '>=', "$year-10-01")->where('fecha', '<=', "$year-10-31")->sum('total');
        $noviembre = Ingreso::where('fecha', '>=', "$year-11-01")->where('fecha', '<=', "$year-11-30")->sum('total'); // Corregido
        $diciembre = Ingreso::where('fecha', '>=', "$year-12-01")->where('fecha', '<=', "$year-12-31")->sum('total');

        $dataMes = collect([

            ['descripcion' => 'Enero', 'total' => $enero],
            ['descripcion' => 'Febrero', 'total' => $febrero],
            ['descripcion' => 'Marzo', 'total' => $marzo],
            ['descripcion' => 'Abril', 'total' => $abril],
            ['descripcion' => 'Mayo', 'total' => $mayo],
            ['descripcion' => 'Junio', 'total' => $junio],
            ['descripcion' => 'Julio', 'total' => $julio],
            ['descripcion' => 'Agosto', 'total' => $agosto],
            ['descripcion' => 'Septiembre', 'total' => $septiembre],
            ['descripcion' => 'Octubre', 'total' => $octubre],
            ['descripcion' => 'Noviembre', 'total' => $noviembre],
            ['descripcion' => 'Diciembre', 'total' => $diciembre],
        ]);

        $dataMes->toJson();

   

        $periodo1 = Ingreso::where('fecha', '>=', "$year-$numMes-01")
            ->where('fecha', '<=', "$year-$numMes-10")->sum('total');
        $periodo2 = Ingreso::where('fecha', '>=', "$year-$numMes-11")
            ->where('fecha', '<=', "$year-$numMes-20")->sum('total');
        
        // Calcular el último día del mes actual para el período 3
        $ultimoDiaMes = date('t', mktime(0, 0, 0, $numMes, 1, $year));
        $periodo3 = Ingreso::where('fecha', '>=', "$year-$numMes-21")
            ->where('fecha', '<=', "$year-$numMes-$ultimoDiaMes")->sum('total');

        // total de los tres periodos (evita división por cero)
        $periodoTotal = $periodo1 + $periodo2 + $periodo3;

        if ($periodoTotal > 0) {
            $p1 = round(($periodo1 * 100) / $periodoTotal, 2);
            $p2 = round(($periodo2 * 100) / $periodoTotal, 2);
            $p3 = round(($periodo3 * 100) / $periodoTotal, 2);
        } else {
            $p1 = $p2 = $p3 = 0.0;
        }

        $dataSemanal = collect([
            [
                'descripcion' => "01 $mes al 10 $mes",
                'total' => $periodo1,
                'porcentaje' => $p1,
            ],
            [
                'descripcion' => "11 $mes al 20 $mes",
                'total' => $periodo2,
                'porcentaje' => $p2,
            ],
            [
                'descripcion' => "21 $mes al $ultimoDiaMes $mes",
                'total' => $periodo3,
                'porcentaje' => $p3,
            ],
        ]);

        $data = Ingreso::with('categoria')->where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->orderBy('fecha')->get();
        $totalMes = Ingreso::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $totalAnual = Ingreso::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-12-31")->sum('total');
        
        // Calcular fecha final del mes anterior correctamente
        $fechaFinalMesAnterior = "$yearA-$numMesA-" . date('t', mktime(0, 0, 0, $numMesA, 1, $yearA));
        $mesAnterior = Ingreso::where('fecha', '>=', "$yearA-$numMesA-01")->where('fecha', '<=', $fechaFinalMesAnterior)->sum('total');
        $diferencia = $totalMes - $mesAnterior;
        if ($mesAnterior < $totalMes) {
            $diferencia = number_format($diferencia, 2);
            $diferencia = "L. +$diferencia ";
        } else {
            $diferencia = number_format($diferencia, 2);
            $diferencia = "L. $diferencia ";
        }
        $promedioSemanal = $totalMes / 4.5;
        $promedioSemanal = number_format($promedioSemanal, 2);
        $promedioSemanal = "L. $promedioSemanal ";
        $totalMes = number_format($totalMes, 2);
        $totalMes = "L. $totalMes ";
        $totalAnual = number_format($totalAnual, 2);
        $totalAnual = "L. $totalAnual ";

        $dataCategorias = [];
        $categorias = IngresoCategoria::all();
        $contador = count($categorias);

        for ($i = 0; $i < $contador; $i++) {
            $id = $categorias[$i]->id;
            $d = $categorias[$i]->descripcion;

            $total = Ingreso::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
            if ($totalIngreso = Ingreso::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->where('id_categoria', $id)->sum('total')) {
                $p = ($totalIngreso * 100) / $total;
                $p = number_format($p, 2, '.', '');
                $descripcion = "$d | $p%";
                $dataCategorias[$i] = [
                    'descripcion' => $d,
                    'total' => $totalIngreso,
                    'porcentaje' => $p,

                ];
            }
        }
        $columns = array_column($dataCategorias, 'total');
        array_multisort($columns, SORT_DESC, $dataCategorias);


        $titlePeriodos = "$modulo por Periodos";
        $titleCategorias = "$modulo por Categorias";
        $titleGrafica = "$modulo por Mes del $year";

        $headers = array(
            1 => "Descripcion",
            2 => "Porcentaje",
            3 => "Total",
        );

        return Inertia::render('Ingresos/Index', compact(
            'modulo',
            'year',
            'diferencia',
            'totalAnual',
            'dataSemanal',
            'mes',
            'dataMes',
            'data',
            'totalMes',
            'dataCategorias',
            'promedioSemanal',
            'chartLabel',
            'titlePeriodos',
            'titleCategorias',
            'titleGrafica',
            'headers'
        ));
    }

    public static function obtenerMes($n)
    {
        switch ($n) {
            case '01':
                $nombre = "Enero";
                break;
            case '02':
                $nombre = "Febrero";
                break;
            case '03':
                $nombre = "Marzo";
                break;
            case '04':
                $nombre = "Abril";
                break;
            case '05':
                $nombre = "Mayo";
                break;
            case '06':
                $nombre = "Junio";
                break;
            case '07':
                $nombre = "Julio";
                break;
            case '08':
                $nombre = "Agosto";
                break;
            case '09':
                $nombre = "Septiembre";
                break;
            case '10':
                $nombre = "Octubre";
                break;
            case '11':
                $nombre = "Noviembre";
                break;
            case '12':
                $nombre = "Diciembre";
                break;

            default:
                # code...
                break;
        }
        return $nombre;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
