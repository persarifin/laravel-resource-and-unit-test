<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::updateOrCreate([
            'name' => 'Arifin',
            'email'=> 'arifin@gmail.com',
        ],[
            'name' => 'Arifin',
            'email'=> 'arifin@gmail.com',
            'username' => 'arifin',
            'phone' => '08123456789',
            'address' => 'Sumenep',
            'city' => 'Sumenep',
            'postcode' => '1234567',
            'country' => 'Indonesia',
            'password' => Hash::make('password')
        ]);
    }
}
