<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Punto;
use Illuminate\Http\Request;

class PuntoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $punto = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
            ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorrido_id', 'recorridos.linea_id', 'recorridos.color')
            ->where('recorridos.linea_id', $request->recorrido)
            ->first();
            $id = $punto->recorrido_id;
            $punto = $punto->recorrido_id % 2;
            if($punto == $request->par){
                $puntos = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
                ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorrido_id', 'recorridos.linea_id', 'recorridos.color')
                ->where('recorridos.linea_id', $request->recorrido)->where('recorridos.id', $id)
                ->get();
            }else{
                $id = $id + 1;
                $puntos = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
                ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorrido_id', 'recorridos.linea_id', 'recorridos.color')
                ->where('recorridos.linea_id', $request->recorrido)->where('recorridos.id', $id)
                ->get();
            }
            return response()->json(['mensaje' => 'Consulta exitosa', 'data' => $puntos], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function ruta()
    {
        try {
            $puntos = Punto::orderBy('recorrido_id', 'asc')->orderBy('orden', 'asc')->get();
            return response()->json(['mensaje' => 'Consulta exitosa', 'data' => $puntos], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function transbordo(Request $request)
    {
        try {
            //Hallar puntoorigen1 y puntorigen2
            $puntoorigen = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('id', $request->fidorigen)->first();
            $puntosorigen = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('recorrido_id', $puntoorigen->recorrido_id)->get();

            $puntodestino = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('id', $request->fiddestino)->first();
            $puntosdestino = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('recorrido_id', $puntodestino->recorrido_id)->get();

            $cant1 = count($puntosorigen);
            $cant2 = count($puntosdestino);
            $ordenorigen = 0;
            $ordendestino = 0;
            for ($i=0; $i < $cant1; $i++) {
                for($j=0; $j < $cant2; $j++){
                    if($puntosorigen[$i]->FID_stops2 == $puntosdestino[$j]->FID_stops2){
                        $ordenorigen = $puntosorigen[$i]->orden;
                        $ordendestino = $puntosdestino[$j]->orden;
                    }
                }
            }

            $array = [];
            $array2 = [];
            if($puntoorigen->orden < $ordenorigen){
                for ($i=$puntoorigen->orden; $i <= $ordenorigen; $i++) {
                    array_push($array, $puntosorigen[$i-1]);
                }
            }else{
                for ($i=$ordenorigen; $i <= $puntoorigen->orden; $i++) {
                    array_push($array, $puntosorigen[$i-1]);
                }
            }

            if($puntodestino->orden < $ordendestino){
                for ($i=$puntodestino->orden; $i <= $ordendestino; $i++) {
                    array_push($array2, $puntosdestino[$i-1]);
                }
            }else{
                for ($i=$ordendestino; $i <= $puntodestino->orden; $i++) {
                    array_push($array2, $puntosdestino[$i-1]);
                }
            }
            
            $array = array_reverse($array);
            $array2 = array_reverse($array2);

            $count = count($array2);
            for ($i=0; $i < $count; $i++) {
                array_push($array, $array2[$i]);
            }

            return response()->json(['mensaje' => 'Consulta exitosa', 'data' => $array], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function allPoints(){
        return Punto::select('id', 'orden', 'Punto', 'PuntoD', 'longi', 'lati', 'LongiD', 'LatiD', 'recorrido_id')->get();
    }
}
