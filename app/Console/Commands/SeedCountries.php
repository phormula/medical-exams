<?php

namespace App\Console\Commands;

use App\Models\Region;
use App\Models\States;
use App\Models\Cities;
use App\Models\postal_codes;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedCountries extends Command
{
    protected $signature = 'geolocate:seed';

    protected $description = 'Seed regions, provinces, cities and postal codes (single sql files are in ./data folder)';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Seeding Countries tables. Please wait...');
        $files = [
            'reset' => '*',
            'regions' => Region::class,
            'states' => States::class,
            'cities_1' => Cities::class,
            'cities_2' => Cities::class,
            'postal_codes_1' => postal_code::class,
            'postal_codes_2' => postal_code::class,
        ];
        
        

        DB::beginTransaction();        

        foreach ($files as $file => $model):        
            $path = __DIR__.'/../../../database/data/'.$file.'.sql';            
            if (file_exists($path)) {
                
                $this->info('Seeding '.$file.'...');
               
                $h = fopen($path, 'r');
                //$this->info(fread($h, filesize($path)));
                $content = fread($h, filesize($path));
                DB::unprepared($content);
                
                fclose($h);
            } else {
                DB::rollback();
                $this->error($file.' file not found');
                return;
            }
        endforeach;

        DB::commit();
        
    }
}
