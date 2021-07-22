<?php

namespace Database\Seeders;

use App\Models\Structure;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // insert medical exams
        for ($x = 1; $x <= 20; $x++){
            DB::table('exams')->insert([
                'name' => 'E'.$x.' '.Str::random(1).' '.Str::random(1).' '.Str::random(1),
            ]);
        }
        // create random users(structure managers) to fill database 
        for ($x = 1; $x <= 50; $x++){
            DB::table('users')->insert([
                'name' => 'Structure'.$x,
                'email' => 'structure'.$x.'@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => today(),
                'updated_at' => today(),
            ]);

            // insert structure details for each structure manager
            DB::table('structures')->insert([
                'name' => 'S'.$x,
                'city_id' => rand(1,8000),
                'phone' => '+39'.rand(1000000000,9999999999),
                'user_id' => $x,
                'address' => 'Via '.Str::random(5).' '.Str::random(8).' '.rand(1,99),
                'created_at' => today(),
                'updated_at' => today(),
            ]);

            // insert and assign medical exams to structures - 9 for each
            for ($i = 0; $i <= 8; $i++){
                DB::table('structure_exams')->insert([
                    'structure_id' => $x,
                    'exam_id' => rand(1,20),
                ]);
            }
        }
        // make 3 random structures premium
        for ($i = 0; $i <= 2; $i++){
            Structure::where('user_id', rand(1,50))
                ->update([
                    'premium' => 1,
                ]);
        }
    }
}
