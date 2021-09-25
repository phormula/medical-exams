<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ExamSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GeolocateSeeder;
use Database\Seeders\StructureSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GeolocateSeeder::class,
            ExamSeeder::class,
            UserSeeder::class,
            StructureSeeder::class,
        ]);
    }
}
