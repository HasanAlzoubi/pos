<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded=[];
    protected $casts=[
      'phone'=>'array' //convert string to array
    ];

    public function getNameAttribute($value){
        return ucfirst($value);
    }

    public function orders(){
      return $this->hasMany(Order::class);
    }
}
