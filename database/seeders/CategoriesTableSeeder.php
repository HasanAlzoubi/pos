<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;


class CategoriesTableSeeder extends Seeder
{

    public function run()
    {
        $Categories=['food','tool'];
        foreach ($Categories as $Category)
        \App\Models\Category::create([
            'name'=>$Category
        ]);

        $products =['fish','checkin'];

        foreach($products as $product)
            \App\Models\Product::create([
                'category_id'=>1,
                'name'=>$product,
                'description'=>$product.'_food',
                'purchase_price'=>100,
                'sale_price'=>150,
                'stock'=>50,

            ]);
    }
}
