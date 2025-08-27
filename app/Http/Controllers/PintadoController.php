<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pintado;
use App\Models\Auto;
use App\Models\Cliente;
use App\Models\Servicio;
use Illuminate\Support\Arr;
use Inertia\Inertia;


class PintadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = "Servicios Automotrices";
        $chartLabel = "Pintados Automotrices del Mes";
        $mes= now()->format('F');
        $numMes = now()->format('m');
        $mes= $this->obtenerMes($numMes);
        $year = now()->format('y');

        if($numMes== 1){
            $numMesA=12;
            $yearA= $year-1;
        }else{
            $numMesA = $numMes-1;
            $yearA= $year-1;
        }


        $fecha_inicial="$year-01-01";
        $fecha_final="$year-$numMes-31";

        $enero=count(Pintado::where('registro', '>=', "$year-01-01")->where('registro', '<=',  "$year-01-31")->get());
        $febrero=count(Pintado::where('registro', '>=', "$year-02-01")->where('registro', '<=', "$year-02-31")->get());
        $marzo=count(Pintado::where('registro', '>=', "$year-03-01")->where('registro', '<=', "$year-03-31")->get());
        $abril=count(Pintado::where('registro', '>=', "$year-04-01")->where('registro', '<=', "$year-04-31")->get());
        $mayo=count(Pintado::where('registro', '>=', "$year-05-01")->where('registro', '<=', "$year-05-31")->get());
        $junio=count(Pintado::where('registro', '>=', "$year-06-01")->where('registro', '<=', "$year-06-31")->get());
        $julio=count(Pintado::where('registro', '>=', "$year-07-01")->where('registro', '<=',"$year-07-31")->get());
        $agosto=count(Pintado::where('registro', '>=',"$year-08-01")->where('registro', '<=', "$year-08-31")->get());
        $septiembre=count(Pintado::where('registro', '>=', "$year-09-01")->where('registro', '<=',"$year-09-31")->get());
        $octubre=count(Pintado::where('registro', '>=', "$year-10-01")->where('registro', '<=', "$year-10-31")->get());
        $noviembre=count(Pintado::where('registro', '>=', "$year-11-01")->where('registro', '<=', "$year-11-31")->get());
        $diciembre=count(Pintado::where('registro', '>=', "$year-12-01")->where('registro', '<=', "$year-12-31")->get());

        $totalAnual=count(Pintado::where('registro', '>=',"$year-01-01")->where('registro', '<=', "$year-12-31")->get());
        $totalAnual= " $totalAnual Vehiculos";
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


        $periodo1=count(Pintado::where('registro', '>=', "$year-$numMes-01")->where('registro', '<=', "$year-$numMes-10")->get());
        $periodo2=count(Pintado::where('registro', '>=', "$year-$numMes-11")->where('registro', '<=', "$year-$numMes-20")->get());
        $periodo3=count(Pintado::where('registro', '>=', "$year-$numMes-21")->where('registro', '<=', "$year-$numMes-31")->get());


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
                 'descripcion' => "01 $mes al 10 $mes",
                'total' => $periodo1,
                'porcentaje' => $p1,
            ],
            [
                'descripcion' => "01 $mes al 10 $mes",
                'total' => $periodo1,
                'porcentaje' => $p1,
            ],
        ]);
        $pintados = Pintado::with('cliente')->with('auto')->where('registro', '>=', $fecha_inicial)->where('registro', '<=', $fecha_final)->orderBy('registro')->get();
        $totalMes=  count($pintados);

        $mesAnterior= count(Pintado::where('registro', '>=', "$yearA-$numMesA-01")->where('registro', '<=', "$yearA-$numMesA-31")->get());
        $diferencia= $totalMes-$mesAnterior;
        if($mesAnterior<$totalMes){
            $diferencia = number_format($diferencia, 2);
             $diferencia= " +$diferencia Vehiculos";
        }else{
            $diferencia = number_format($diferencia, 2);
             $diferencia= " $diferencia Vehiculos ";
        }

        $promedioSemanal= $totalMes/4.5;
        $promedioSemanal = number_format($promedioSemanal, 0);

        $totalMes= " $totalMes Vehiculos";
        $promedioSemanal=  " $promedioSemanal Vehiculos";

        $dataMarcas=[];
        $autos= Auto::all();
        $contador= count($autos);

        for($i=0; $i<$contador; $i++)
        {
           $id= $autos[$i]->id;
           $marca= $autos[$i]->marca;
           $modelo = $autos[$i]->modelo;
           $d = "$marca $modelo";
           $totalMesData= Pintado::where('registro', '>=', $fecha_inicial)->where('registro', '<=', $fecha_final)->get();
           $totalMesData=count($totalMesData);

           $busqueda= Pintado::where('registro', '>=', $fecha_inicial)->where('registro', '<=', $fecha_final)->where('id_auto',$id)->get();
           $cantidad= count($busqueda);
            if ($cantidad>0) {
                $p= ($cantidad*100)/$totalMesData;
                $p = number_format($p, 2, '.', '');
                $descripcion= "$d | $p%";
                $dataMarcas[$i] = Arr::add(['descripcion' => $descripcion], 'total', $cantidad);
            }



        }
        $columns = array_column($dataMarcas, 'total');
        array_multisort($columns, SORT_DESC, $dataMarcas);


        $clientes= Cliente::all();
        $clientesI=[];
        $contador= count($clientes);
        $p= 0;
        $mayor=0;
        $clienteFrecuente="";

        for($i=0; $i<$contador; $i++)
        {
            $id= $clientes[$i]->id_cliente;
            $pClientes= Pintado::where('registro', '>=', $fecha_inicial)->where('registro', '<=', $fecha_final)->where('id_cliente',$id)->get();
            $cantidad= count($pClientes);
            $actual= $cantidad;
            if($actual>$mayor){
                $clienteFrecuente= $clientes[$i]->nombre;
                $mayor=$actual;
            }
        }
        $columns = array_column($clientesI, 'total');
        array_multisort($columns, SORT_DESC, $clientesI);

        $titleProveedores ="$modulo por Proveedores";
        $titlePeriodos ="$modulo por Periodos";
        $titleCategorias ="$modulo por Marcas";
        $titleGrafica ="$modulo por Mes del $year";

        $headers = array(
            1 => "Descripcion",
            2 => "Porcentaje",
            3 => "Total",
        );

        return Inertia::render('Pintados/Index', compact('year','clienteFrecuente', 'totalAnual','dataMarcas',
        'mes','dataMes','dataSemanal','totalMes','diferencia','promedioSemanal','chartLabel','modulo',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
