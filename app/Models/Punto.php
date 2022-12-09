<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punto extends Model
{
    protected $fillable = [
        'id',
        'Shape',
        'FID_stops2',
        'Longi',
        'Lati',
        'Punto',
        'Tipo',
        'code',
        'orden',
        'PuntoD',
        'LongiD',
        'LatiD',
        'recorrido_id',
    ];

    use HasFactory;

    public function recorrido(){
        return $this->belongsTo(Recorrido::class, 'recorrido_id');
    }
}
