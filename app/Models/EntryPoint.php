<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryPoint extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'lat',
        'long',
        'bus_route_id',

    ];

    public function scopeBusRoute($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('bus_route_id',$id); }
    }

}
