<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\GastoCategoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Arr;

class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = "Gastos";
        $chartLabel = "Gastos del Mes";
        $mes= now()->format('F');
        $numMes = now()->format('m');
        $mes= $this->obtenerMes($numMes);
        $year = now()->format('Y');

        if($numMes== 1){
            $numMesA=12;
            $yearA= $year-1;
        }else{
            $numMesA = $numMes-1;
            $yearA= $year;
        }

        $fecha_inicial="$year-$numMes-01";
        $fecha_final="$year-$numMes-" . date('t', mktime(0, 0, 0, $numMes, 1, $year));


        $enero=Gasto::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-01-31")->sum('total');
        $febrero=Gasto::where('fecha', '>=', "$year-02-01")->where('fecha', '<=', "$year-02-" . date('t', mktime(0, 0, 0, 2, 1, $year)))->sum('total');
        $marzo=Gasto::where('fecha', '>=', "$year-03-01")->where('fecha', '<=',"$year-03-31")->sum('total');
        $abril=Gasto::where('fecha', '>=', "$year-04-01")->where('fecha', '<=', "$year-04-30")->sum('total');
        $mayo=Gasto::where('fecha', '>=', "$year-05-01")->where('fecha', '<=', "$year-05-31")->sum('total');
        $junio=Gasto::where('fecha', '>=', "$year-06-01")->where('fecha', '<=', "$year-06-30")->sum('total');
        $julio=Gasto::where('fecha', '>=', "$year-07-01")->where('fecha', '<=',  "$year-07-31")->sum('total');
        $agosto=Gasto::where('fecha', '>=', "$year-08-01")->where('fecha', '<=', "$year-08-31")->sum('total');
        $septiembre=Gasto::where('fecha', '>=', "$year-09-01")->where('fecha', '<=',"$year-09-30")->sum('total');
        $octubre=Gasto::where('fecha', '>=', "$year-10-01")->where('fecha', '<=', "$year-10-31")->sum('total');
        $noviembre=Gasto::where('fecha', '>=', "$year-11-01")->where('fecha', '<=', "$year-11-30")->sum('total');
        $diciembre=Gasto::where('fecha', '>=', "$year-12-01")->where('fecha', '<=', "$year-12-31")->sum('total');

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

        $periodo1=Gasto::where('fecha', '>=', "$year-$numMes-01")->where('fecha', '<=', "$year-$numMes-10")->sum('total');
        $periodo2=Gasto::where('fecha', '>=', "$year-$numMes-11")->where('fecha', '<=', "$year-$numMes-20")->sum('total');
        $finalMes = date('t', mktime(0, 0, 0, $numMes, 1, $year));
        $periodo3=Gasto::where('fecha', '>=', "$year-$numMes-21")->where('fecha', '<=', "$year-$numMes-$finalMes")->sum('total');

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
                'descripcion' => "21 $mes al $finalMes $mes",
                'total' => $periodo3,
                'porcentaje' => $p3,
            ],
        ]);

        $data = Gasto::with('categoria')->where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->orderBy('fecha')->get();
        $totalMes=  Gasto::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $totalAnual=Gasto::where('fecha', '>=',"$year-01-01")->where('fecha', '<=', "$year-12-31")->sum('total');
        $finalMesAnterior = date('t', mktime(0, 0, 0, $numMesA, 1, $yearA));
        $mesAnterior=Gasto::where('fecha', '>=', "$yearA-" . str_pad($numMesA, 2, '0', STR_PAD_LEFT) . "-01")->where('fecha', '<=', "$yearA-" . str_pad($numMesA, 2, '0', STR_PAD_LEFT) . "-$finalMesAnterior")->sum('total');
        $diferencia= $totalMes-$mesAnterior;
        if($mesAnterior<$totalMes){
            $diferencia = number_format($diferencia, 2);
            $diferencia= "L. +$diferencia ";
        }else{
            $diferencia = number_format($diferencia, 2);
            $diferencia= "L. $diferencia ";
        }
        $promedioSemanal= $totalMes/4.5;
        $promedioSemanal = number_format($promedioSemanal, 2);
        $promedioSemanal= "L. $promedioSemanal ";
        $totalMes = number_format($totalMes, 2);
        $totalMes= "L. $totalMes ";
        $totalAnual = number_format($totalAnual, 2);
        $totalAnual= "L. $totalAnual ";

        $dataCategorias=[];
        $categorias= GastoCategoria::all();

        foreach($categorias as $categoria)
        {
           $id= $categoria->id;
           $d= $categoria->descripcion;

           $total= Gasto::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
           $totalGasto = Gasto::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->where('id_categoria',$id)->sum('total');
           
           if($totalGasto > 0 && $total > 0){
            $p= ($totalGasto*100)/$total;
            $p = number_format($p, 2, '.', '');
              $dataCategorias[] = [
                    'descripcion' => $d,
                    'total' => $totalGasto,
                    'porcentaje' => $p,
                ];
           }
        }
        $columns = array_column($dataCategorias, 'total');
        array_multisort($columns, SORT_DESC, $dataCategorias);

        $titlePeriodos =" $modulo por Periodos";
        $titleCategorias =" $modulo por Categorias";
        $titleGrafica ="$modulo por Mes del $year";

         $headers = array(
            1 => "Descripcion",
            2 => "Porcentaje",
            3 => "Total",
        );


        return Inertia::render('Gastos/Index', compact('year','diferencia','totalAnual','dataSemanal',
        'mes','dataMes','data','totalMes','dataCategorias','promedioSemanal','chartLabel',
        'modulo','titlePeriodos','titleCategorias','titleGrafica','headers'));
    }
    public static function obtenerMes($n){
        switch ($n) {
            case '01':
                $nombre="Enero";
                break;
                case '02':
                $nombre="Febrero";
                break;
                case '03':
                $nombre="Marzo";
                break;
                case '04':
                $nombre="Abril";
                break;
                case '05':
                $nombre="Mayo";
                break;
                case '06':
                $nombre="Junio";
                break;
                case '07':
                $nombre="Julio";
                break;
                case '08':
                $nombre="Agosto";
                break;
                case '09':
                $nombre="Septiembre";
                break;
                case '10':
                $nombre="Octubre";
                break;
                case '11':
                $nombre="Noviembre";
                break;
                case '12':
                $nombre="Diciembre";
                break;

            default:
                # code...
                break;
        }
        return $nombre;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function show(Gasto $gasto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function edit(Gasto $gasto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gasto $gasto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gasto $gasto)
    {
        //
    }
}
