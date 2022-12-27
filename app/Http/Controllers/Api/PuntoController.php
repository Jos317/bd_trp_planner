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
            ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorridos_id', 'recorridos.linea_id', 'recorridos.color')
            ->where('recorridos.linea_id', $request->recorrido)
            ->first();
            $id = $punto->recorridos_id;
            $punto = $punto->recorridos_id % 2;
            if($punto == $request->par){
                $puntos = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
                ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorridos_id', 'recorridos.linea_id', 'recorridos.color')
                ->where('recorridos.linea_id', $request->recorrido)->where('recorridos.id', $id)
                ->get();
            }else{
                $id = $id + 1;
                $puntos = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
                ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorridos_id', 'recorridos.linea_id', 'recorridos.color')
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
            $puntoorigen = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('id', $request->fidorigen)->first();
            $puntosorigen = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('recorrido_id', $puntoorigen->recorrido_id)->where('orden', '>', $puntoorigen->orden)->get();
            $puntodestino = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('id', $request->fiddestino)->first();
            $puntosdestino = Punto::select('id', 'Shape', 'FID_stops2', 'longi', 'lati', 'Punto', 'Tipo', 'orden', 'PuntoD', 'LongiD', 'LatiD', 'recorrido_id')
            ->where('recorrido_id', $puntodestino->recorrido_id)->where('orden', '>', $puntodestino->orden)->get();
            $ruta = $puntoorigen;
            $array = [];
            array_push($array, $ruta);
            $cant = count($puntosorigen);
            for ($i=0; $i < $cant; $i++) { 
                array_push($array, $puntosorigen[$i]);
            }
            // $id = $punto->recorridos_id;
            // $punto = $punto->recorridos_id % 2;
            // if($punto == $request->par){
            //     $puntos = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
            //     ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorridos_id', 'recorridos.linea_id', 'recorridos.color')
            //     ->where('recorridos.linea_id', $request->recorrido)->where('recorridos.id', $id)
            //     ->get();
            // }else{
            //     $id = $id + 1;
            //     $puntos = Punto::join('recorridos', 'puntos.recorrido_id', 'recorridos.id')
            //     ->select('puntos.id', 'puntos.longi', 'puntos.lati', 'recorridos.id as recorridos_id', 'recorridos.linea_id', 'recorridos.color')
            //     ->where('recorridos.linea_id', $request->recorrido)->where('recorridos.id', $id)
            //     ->get();
            // }
            return response()->json(['mensaje' => 'Consulta exitosa', 'data' => $array], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
