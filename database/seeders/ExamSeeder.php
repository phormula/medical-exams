<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert medical exams
        for ($x = 1; $x <= 20; $x++){
            Exam::create([
                'name' => 'E'.$x.' '.Str::random(1).' '.Str::random(1).' '.Str::random(1),
            ]);
        }
    }
}
