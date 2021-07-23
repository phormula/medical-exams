<?php

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\StructureExam;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/activity', function(){
    return Activity::all();
});

Route::get('/structures', function(Request $request) {

    $exams = $request->input('search');

        if($request->input('sortBy')){
            $sort = $request->input('sortBy');
        }else{
            $sort = '';
        }

        // $this->validate($request, [
        //     'search' => 'alpha_dash',
        // ]);

        //get structures based on search term
        $structures = StructureExam::query()
            ->join('exams', 'structure_exams.exam_id', '=', 'exams.id')
            ->join('structures', 'structure_exams.structure_id', '=', 'structures.id')
            ->join('cities', 'structures.city_id', '=', 'cities.id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->join('regions', 'states.region_id', '=', 'regions.id')
            ->join('postal_codes', 'cities.id', '=', 'postal_codes.city_id')
            ->select('structures.name as name', 'cities.name as city', 'postal_codes.code as zip',
            'states.name as state', 'regions.name as region', 'structures.address as address',
            'structures.premium as premium')
            ->where('exams.name', 'LIKE', "%{$exams}%")
            ->groupBy('structures.name')
            ->orderBy('structures.premium', 'DESC')
            ->orderBy("{$sort}")
            ->paginate(10);

        //apend $_GET variables to URL
        $structures->appends([
            'search' => $exams,
            'sortBy' => $sort,
        ]);

        return $structures;
});