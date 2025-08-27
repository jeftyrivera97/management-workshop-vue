<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraCategoria;
use App\Models\Proveedor;
use Inertia\Inertia;
use Illuminate\Support\Arr;


class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = "Compras";
        $chartLabel = "Compras del Mes";
        $mes = now()->format('F');
        $numMes = now()->format('m');
        $mes = $this->obtenerMes($numMes);
        $year = now()->format('Y'); // Cambiar 'y' por 'Y' para año completo

        if($numMes == '01'){
            $numMesA = '12';
            $yearA = $year - 1;
        }else{
            $numMesA = str_pad($numMes - 1, 2, '0', STR_PAD_LEFT);
            $yearA = $year;
        }

        // Remover esta línea que hardcodea enero
        // $numMes = '01';

        $fecha_inicial = "$year-$numMes-01";
        $fecha_final = "$year-$numMes-" . now()->format('t'); // Usar 't' para último día del mes actual

        $enero=Compra::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-01-31")->sum('total');
        $febrero=Compra::where('fecha', '>=', "$year-02-01")->where('fecha', '<=', "$year-02-28")->sum('total'); // Corregido
        $marzo=Compra::where('fecha', '>=', "$year-03-01")->where('fecha', '<=',"$year-03-31")->sum('total');
        $abril=Compra::where('fecha', '>=', "$year-04-01")->where('fecha', '<=', "$year-04-30")->sum('total'); // Corregido
        $mayo=Compra::where('fecha', '>=', "$year-05-01")->where('fecha', '<=', "$year-05-31")->sum('total');
        $junio=Compra::where('fecha', '>=', "$year-06-01")->where('fecha', '<=', "$year-06-30")->sum('total'); // Corregido
        $julio=Compra::where('fecha', '>=', "$year-07-01")->where('fecha', '<=',  "$year-07-31")->sum('total');
        $agosto=Compra::where('fecha', '>=', "$year-08-01")->where('fecha', '<=', "$year-08-31")->sum('total');
        $septiembre=Compra::where('fecha', '>=', "$year-09-01")->where('fecha', '<=', "$year-09-30")->sum('total'); // Corregido
        $octubre=Compra::where('fecha', '>=', "$year-10-01")->where('fecha', '<=', "$year-10-31")->sum('total');
        $noviembre=Compra::where('fecha', '>=', "$year-11-01")->where('fecha', '<=', "$year-11-30")->sum('total'); // Corregido
        $diciembre=Compra::where('fecha', '>=', "$year-12-01")->where('fecha', '<=', "$year-12-31")->sum('total');

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


        $periodo1=Compra::where('fecha', '>=', "$year-$numMes-01")->where('fecha', '<=', "$year-$numMes-10")->sum('total');
        $periodo2=Compra::where('fecha', '>=', "$year-$numMes-11")->where('fecha', '<=', "$year-$numMes-20")->sum('total');
        
        // Calcular el último día del mes actual para el período 3
        $ultimoDiaMes = date('t', mktime(0, 0, 0, $numMes, 1, $year));
        $periodo3=Compra::where('fecha', '>=', "$year-$numMes-21")->where('fecha', '<=', "$year-$numMes-$ultimoDiaMes")->sum('total');

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



        $data = Compra::with('categoria')->with('proveedor')->where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->orderBy('fecha')->get();
        $totalC = Compra::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $totalMes = Compra::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $totalAnual = Compra::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-12-31")->sum('total');
        $totalAnual = number_format($totalAnual, 2);
        $totalAnual = "L. $totalAnual ";

        // Calcular fecha final del mes anterior correctamente
        $fechaFinalMesAnterior = "$yearA-$numMesA-" . date('t', mktime(0, 0, 0, $numMesA, 1, $yearA));
        $mesAnterior = Compra::where('fecha', '>=', "$yearA-$numMesA-01")->where('fecha', '<=', $fechaFinalMesAnterior)->sum('total');
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

        $dataCategorias=[];
        $categorias= CompraCategoria::all();
        
      
        $totalGeneral = Compra::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');

        foreach($categorias as $categoria)
        {
           $id = $categoria->id;
           $d = $categoria->descripcion;
           
           $totalCompra = Compra::where('fecha', '>=', $fecha_inicial)
                               ->where('fecha', '<=', $fecha_final)
                               ->where('id_categoria', $id)
                               ->sum('total');
           
           if($totalCompra > 0 && $totalGeneral > 0){
            $p = ($totalCompra * 100) / $totalGeneral;
            $p = number_format($p, 2, '.', '');
            
            $dataCategorias[] = [
                'descripcion' => $d,
                'total' => $totalCompra,
                'porcentaje' => $p,
            ];
           }
        }
        
        // Ordenar por total descendente
        if(count($dataCategorias) > 0) {
            $columns = array_column($dataCategorias, 'total');
            array_multisort($columns, SORT_DESC, $dataCategorias);
        }

        $dataProveedores=[];
        $proveedores= Proveedor::all();

        foreach($proveedores as $proveedor)
        {
           $id = $proveedor->id;
           $d = $proveedor->descripcion;
           
           $totalCompra = Compra::where('fecha', '>=', $fecha_inicial)
                               ->where('fecha', '<=', $fecha_final)
                               ->where('id_proveedor', $id)
                               ->sum('total');
           
           if($totalCompra > 0 && $totalGeneral > 0){
            $p = ($totalCompra * 100) / $totalGeneral;
            $p = number_format($p, 2, '.', '');
            
            $dataProveedores[] = [
                'descripcion' => $d,
                'total' => $totalCompra,
                'porcentaje' => $p,
            ];
           }
        }
        
        // Ordenar por total descendente
        if(count($dataProveedores) > 0) {
            $columns = array_column($dataProveedores, 'total');
            array_multisort($columns, SORT_DESC, $dataProveedores);
        }

        $titleProveedores ="$modulo por Proveedores";
        $titlePeriodos ="$modulo por Periodos";
        $titleCategorias ="$modulo por Categorias";
        $titleGrafica ="$modulo por Mes del $year";

         $headers = array(
            1 => "Descripcion",
            2 => "Porcentaje",
            3 => "Total",
        );

        return Inertia::render('Compras/Index', compact('dataProveedores','year','diferencia','totalAnual','dataSemanal','mes',
        'dataMes','data','totalMes','dataCategorias','promedioSemanal','modulo','chartLabel',
        'titleProveedores','headers','titlePeriodos','titleCategorias','titleGrafica'));
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

}
