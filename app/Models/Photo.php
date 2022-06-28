<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'image',
        'bus_id',

    ];

    public function scopeBus($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('bus_id',$id); }
    }

}
