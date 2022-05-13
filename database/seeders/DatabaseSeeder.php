<?php
//namespace Database\Seeders;

use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ClientsTableSeeder;
use Database\Seeders\LaratrustSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
         $this->call(LaratrustSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
//        $this->call(ProductsTableSeeder::class);
         $this->call(ClientsTableSeeder::class);



    }
}
