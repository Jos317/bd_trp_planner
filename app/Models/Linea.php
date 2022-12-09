<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $fillable = [
        'id',
        'code',
        'direccion',
        'telefono',
        'email',
        'foto',
        'descripcion',
    ];
    use HasFactory;

    public function recorrido(){
        return $this->belongsTo(Recorrido::class, 'linea_id');
    }
}
