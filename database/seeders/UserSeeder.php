<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create random users(structure managers) to fill database 
        for ($x = 1; $x <= 50; $x++){
            User::create([
                'name' => 'Structure'.$x,
                'email' => 'structure'.$x.'@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => today(),
                'updated_at' => today(),
            ]);
        }
    }
}
