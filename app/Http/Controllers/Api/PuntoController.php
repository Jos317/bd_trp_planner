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
}
