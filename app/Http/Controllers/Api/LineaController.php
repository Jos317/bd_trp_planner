<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Linea;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public function index(){
        return Linea::all();
    }
}
