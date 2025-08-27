<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use App\Models\Compra;
use App\Models\Gasto;
use App\Models\Ingreso;
use App\Models\Planilla;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $chartLabel = 'Ingresos y Egresos por Mes';
        $mes= now()->format('F');
        $numMes = now()->format('m');
        $mes= $this->obtenerMes($numMes);
        $year = now()->format('y');

        if($numMes== 1){
            $numMesA=12;
            $yearA= $year-1;
        }else{
            $numMesA = $numMes-1;

        }

        $fecha_inicial="$year-$numMes-01";
        $fecha_final="$year-$numMes-31";
        $fecha_inicialAnual="$year-01-01";
        $fecha_finalAnual="$year-12-31";
        $fecha= now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');


        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        $gastos=Gasto::where('fecha', '>=',  $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $compras=Compra::where('fecha', '>=',  $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $planillas=Planilla::where('fecha', '>=',  $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');

        $ingresos=Ingreso::where('fecha', '>=',  $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');
        $egresos = $gastos+ $compras;

        $egresosMensual= $gastos+$compras;
        $ingresosMensual=Ingreso::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_final)->sum('total');

        if($egresosMensual==0){$egresosMensual=1;}
        if($ingresosMensual==0){$ingresosMensual=1;}


        $gastosAnual=Gasto::where('fecha', '>=',  $fecha_inicialAnual)->where('fecha', '<=', $fecha_finalAnual)->sum('total');
        $comprasAnual=Compra::where('fecha', '>=',  $fecha_inicialAnual)->where('fecha', '<=', $fecha_finalAnual)->sum('total');
        $planillasAnual=Planilla::where('fecha', '>=',  $fecha_inicialAnual)->where('fecha', '<=', $fecha_finalAnual)->sum('total');

        $egresosAnual = $gastosAnual + $comprasAnual;
        $ingresosAnual=Ingreso::where('fecha', '>=',  $fecha_inicialAnual)->where('fecha', '<=', $fecha_finalAnual)->sum('total');


        if($egresosAnual==0){$egresosAnual=1;}
        if($ingresosAnual==0){$ingresosAnual=1;}


        $balance= $ingresosMensual-$egresosMensual;
        $p=100;

        $pBalance= 100;

        $egresosAnual= $gastosAnual+$comprasAnual;
        $balanceAnual= $ingresosAnual-$egresosAnual;
        $p=100;


        $porcentajeAnual= ($egresosAnual*$p)/$ingresosAnual;
        $porcentajeMensual= ($egresosMensual*$p)/$ingresosMensual;

        $balance = number_format($balance, 2);
        if($balance>1){
            $balance= "L. $balance -POSITIVO-";
        }else{
            $balance= "L. $balance -NEGATIVO-";
        }

        
        $balanceAnual = number_format($balanceAnual, 2);
        if($balanceAnual>1){
            $balanceAnual= "L. $balanceAnual -POSITIVO-";
        }else{
            $balanceAnual= "L. $balanceAnual -NEGATIVO-";
        }


        $enero=Ingreso::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-01-31")->sum('total');
        $febrero=Ingreso::where('fecha', '>=', "$year-02-01")->where('fecha', '<=', "$year-02-31")->sum('total');
        $marzo=Ingreso::where('fecha', '>=', "$year-03-01")->where('fecha', '<=', "$year-03-31")->sum('total');
        $abril=Ingreso::where('fecha', '>=', "$year-04-01")->where('fecha', '<=', "$year-04-31")->sum('total');
        $mayo=Ingreso::where('fecha', '>=', "$year-05-01")->where('fecha', '<=', "$year-05-31")->sum('total');
        $junio=Ingreso::where('fecha', '>=', "$year-06-01")->where('fecha', '<=', "$year-06-31")->sum('total');
        $julio=Ingreso::where('fecha', '>=', "$year-07-01")->where('fecha', '<=', "$year-07-31")->sum('total');
        $agosto=Ingreso::where('fecha', '>=', "$year-08-01")->where('fecha', '<=', "$year-08-31")->sum('total');
        $septiembre=Ingreso::where('fecha', '>=', "$year-09-01")->where('fecha', '<=', "$year-09-31")->sum('total');
        $octubre=Ingreso::where('fecha', '>=', "$year-10-01")->where('fecha', '<=', "$year-10-31")->sum('total');
        $noviembre=Ingreso::where('fecha', '>=', "$year-11-01")->where('fecha', '<=', "$year-11-31")->sum('total');
        $diciembre=Ingreso::where('fecha', '>=', "$year-12-01")->where('fecha', '<=', "$year-12-31")->sum('total');


        $dataIngresos = collect([
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

        $dataIngresos->toJson();

        $eneroG=Gasto::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-01-31")->sum('total');
        $febreroG=Gasto::where('fecha', '>=', "$year-02-01")->where('fecha', '<=', "$year-02-31")->sum('total');
        $marzoG=Gasto::where('fecha', '>=', "$year-03-01")->where('fecha', '<=', "$year-03-31")->sum('total');
        $abrilG=Gasto::where('fecha', '>=', "$year-04-01")->where('fecha', '<=', "$year-04-31")->sum('total');
        $mayoG=Gasto::where('fecha', '>=', "$year-05-01")->where('fecha', '<=', "$year-05-31")->sum('total');
        $junioG=Gasto::where('fecha', '>=', "$year-06-01")->where('fecha', '<=', "$year-06-31")->sum('total');
        $julioG=Gasto::where('fecha', '>=', "$year-07-01")->where('fecha', '<=', "$year-07-31")->sum('total');
        $agostoG=Gasto::where('fecha', '>=', "$year-08-01")->where('fecha', '<=', "$year-08-31")->sum('total');
        $septiembreG=Gasto::where('fecha', '>=', "$year-09-01")->where('fecha', '<=', "$year-09-31")->sum('total');
        $octubreG=Gasto::where('fecha', '>=', "$year-10-01")->where('fecha', '<=', "$year-10-31")->sum('total');
        $noviembreG=Gasto::where('fecha', '>=', "$year-11-01")->where('fecha', '<=', "$year-11-31")->sum('total');
        $diciembreG=Gasto::where('fecha', '>=', "$year-12-01")->where('fecha', '<=', "$year-12-31")->sum('total');


        $eneroC=Compra::where('fecha', '>=', "$year-01-01")->where('fecha', '<=', "$year-01-31")->sum('total');
        $febreroC=Compra::where('fecha', '>=', "$year-02-01")->where('fecha', '<=', "$year-02-31")->sum('total');
        $marzoC=Compra::where('fecha', '>=', "$year-03-01")->where('fecha', '<=', "$year-03-31")->sum('total');
        $abrilC=Compra::where('fecha', '>=', "$year-04-01")->where('fecha', '<=', "$year-04-31")->sum('total');
        $mayoC=Compra::where('fecha', '>=', "$year-05-01")->where('fecha', '<=', "$year-05-31")->sum('total');
        $junioC=Compra::where('fecha', '>=', "$year-06-01")->where('fecha', '<=', "$year-06-31")->sum('total');
        $julioC=Compra::where('fecha', '>=', "$year-07-01")->where('fecha', '<=', "$year-07-31")->sum('total');
        $agostoC=Compra::where('fecha', '>=', "$year-08-01")->where('fecha', '<=', "$year-08-31")->sum('total');
        $septiembreC=Compra::where('fecha', '>=', "$year-09-01")->where('fecha', '<=', "$year-09-31")->sum('total');
        $octubreC=Compra::where('fecha', '>=', "$year-10-01")->where('fecha', '<=', "$year-10-31")->sum('total');
        $noviembreC=Compra::where('fecha', '>=', "$year-11-01")->where('fecha', '<=', "$year-11-31")->sum('total');
        $diciembreC=Compra::where('fecha', '>=', "$year-12-01")->where('fecha', '<=', "$year-12-31")->sum('total');

        $totalGastosAnual=Gasto::where('fecha', '>=', $fecha_inicialAnual)->where('fecha', '<=', $fecha_finalAnual)->sum('total');
        $totalComprasAnual=Compra::where('fecha', '>=', $fecha_inicialAnual)->where('fecha', '<=', $fecha_finalAnual)->sum('total');
        $totalEgresosAnual = $totalGastosAnual + $totalComprasAnual;

        $dataEgresos = collect([
            ['descripcion' => 'Enero', 'total' => $eneroG+$eneroC],
            ['descripcion' => 'Febrero', 'total' => $febreroG+$febreroC],
            ['descripcion' => 'Marzo', 'total' => $marzoG+$marzoC],
            ['descripcion' => 'Abril', 'total' => $abrilG+$abrilC],
            ['descripcion' => 'Mayo', 'total' => $mayoG+$mayoC],
            ['descripcion' => 'Junio', 'total' => $junioG+$junioC],
            ['descripcion' => 'Julio', 'total' => $julioG+$julioC],
            ['descripcion' => 'Agosto', 'total' => $agostoG+$agostoC],
            ['descripcion' => 'Septiembre', 'total' => $septiembreG+$septiembreC],
            ['descripcion' => 'Octubre', 'total' => $octubreG+$octubreC],
            ['descripcion' => 'Noviembre', 'total' => $noviembreG+$noviembreC],
            ['descripcion' => 'Diciembre', 'total' => $diciembreG+$diciembreC],
        ]);

        $dataEgresos->toJson();

        $compras = number_format($compras, 2);
        $compras= "L. $compras ";

        $gastos = number_format($gastos, 2);
        $gastos= "L. $gastos ";

        $ingresosMensual = number_format($ingresosMensual, 2);
        $ingresosMensual= "L. $ingresosMensual ";

        $ingresosAnual = number_format($ingresosAnual, 2);
        $ingresosAnual= "L. $ingresosAnual ";

        $totalComprasAnual = number_format($totalComprasAnual, 2);
        $totalComprasAnual= "L. $totalComprasAnual ";

        $totalGastosAnual = number_format($totalGastosAnual, 2);
        $totalGastosAnual= "L. $totalGastosAnual ";



        return Inertia::render('Dashboard', compact('chartLabel','meses','ingresosMensual','dataIngresos','dataEgresos','egresosAnual','totalComprasAnual','totalGastosAnual','ingresosAnual','balanceAnual','porcentajeAnual','porcentajeMensual','balance','fecha','mes','ingresos','gastos','compras','planillas','egresos','year'));
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
}
