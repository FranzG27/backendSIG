<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'placa',
        'modelo',
        'cantidad_asientos',
        'fecha_asignacion',
        'fecha_baja',
        'numero_interno',
        'esta_en_recorrido',
        'user_id',
        'bus_route_id',

    ];

    public function scopeUser($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('user_id',$id); }
    }
    public function scopeBusRoute($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('bus_route_id',$id); }
    }

}
