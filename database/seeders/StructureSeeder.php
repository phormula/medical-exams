<?php

namespace Database\Seeders;

use App\Models\Structure;
use Illuminate\Support\Str;
use App\Models\StructureExam;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert structure details for each structure manager
        for ($x = 1; $x <= 50; $x++){
            Structure::create([
                'name' => 'S'.$x,
                'city_id' => rand(1,8000),
                'phone' => '+39'.rand(1000000000,9999999999),
                'user_id' => $x,
                'address' => 'Via '.Str::random(5).' '.Str::random(8).' '.rand(1,99),
                'created_at' => today(),
                'updated_at' => today(),
            ]);

            // insert and assign medical exams to structures - (9 for each)
            for ($i = 0; $i <= 8; $i++){
                StructureExam::create([
                    'structure_id' => $x,
                    'exam_id' => rand(1,20),
                ]);
            }
        }

        // make 5 random structures premium
        for ($i = 0; $i <= 4; $i++){
            Structure::where('user_id', rand(1,50))
                ->update([
                    'premium' => 1,
                ]);
        }
    }
}
