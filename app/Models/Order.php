<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded=[];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function product(){
       return $this->belongsToMany(Product::class,'product_order');
    }
}
