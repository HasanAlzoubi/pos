<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{

    public function run()
    {
        $names = ['hasan', 'ali', 'ahmad', 'khaled'];
        $phones = [['12345', '123213'], ['12234'], ['12345252', '64346'], ['1241242']];
        foreach ($names as $key => $name) {
            foreach ($phones as $keyp => $phone) {

                if ($key == $keyp) {
                    \App\Models\Client::create([
                        'name' => $name,
                        'phone' => $phone,
                        'address' => 'Damascus',
                    ]);
                }

            }
        }
    }
}
