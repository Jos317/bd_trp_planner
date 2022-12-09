<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    protected $fillable = [
        'id',
        'codigo',
        'tiempo',
        'distancia',
        'velocidad',
        'descripcion',
        'color_linea',
        'grosor',
        'id_linea',
    ];


    use HasFactory;

    public function linea(){
        return $this->hasMany(Linea::class, 'linea_id');
    }

    public function punto(){
        return $this->hasMany(Punto::class, 'recorrido_id');
    }
}
