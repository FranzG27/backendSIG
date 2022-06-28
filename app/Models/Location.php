<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'lat',
        'long',
        'bus_id',
        'bus_route_id',

    ];

    public function scopeBus($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('bus_id',$id); }
    }
    public function scopeBusRoute($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('bus_route_id',$id); }
    }

}
