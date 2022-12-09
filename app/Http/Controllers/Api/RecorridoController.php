<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recorrido;
use Illuminate\Http\Request;

class RecorridoController extends Controller
{
    public function index(){
        return Recorrido::all();
    }
}
