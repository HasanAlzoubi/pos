<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $user=\App\Models\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
          $user->attachRole('super_admin');

    }
}
