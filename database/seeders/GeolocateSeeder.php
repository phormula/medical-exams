<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\States;
use App\Models\Cities;
use App\Models\PostalCode;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class GeolocateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding Geolocation tables. Please wait...');
        $files = [
            // 'reset' => '*',
            'regions' => Region::class,
            'states' => States::class,
            'cities_1' => Cities::class,
            'cities_2' => Cities::class,
            'postal_codes_1' => PostalCode::class,
            'postal_codes_2' => PostalCode::class,
        ];

        DB::beginTransaction();        

        foreach ($files as $file => $model):        
            $path = __DIR__.'/../data/'.$file.'.sql';            
            if (file_exists($path)) {
                
                $this->command->info('Seeding '.$file.'...');
               
                $h = fopen($path, 'r');
                $content = fread($h, filesize($path));
                DB::unprepared($content);
                
                fclose($h);
            } else {
                DB::rollback();
                $this->command->error($file.' file not found');
                return;
            }
        endforeach;

        DB::commit();
    }
}
