<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = ['id'];

    protected $appends=['image_path','profit_percent'];

    protected $fillable=['name','description','category_id','purchase_price','sale_price','stock','image'];


    public function getImagePathAttribute(){
        return asset('uploads/product_images/'.$this->image);
    }

    public function getProfitPercentAttribute()
    {
        return number_format(($this->sale_price - $this->purchase_price)
            /$this->purchase_price*100,2);
    }


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class,'product_order');
    }

}
