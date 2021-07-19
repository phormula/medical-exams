<?php

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\StructureExam;
use Illuminate\Support\Facades\Route;

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

Route::get('/structures', function(Request $request) {

    $exams = $request->input('search');
    return StructureExam::query()
            ->join('exams', 'structure_exams.exam_id', '=', 'exams.id')
            ->join('structures', 'structure_exams.structure_id', '=', 'structures.id')
            ->join('cities', 'structures.city_id', '=', 'cities.id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->join('regions', 'states.region_id', '=', 'regions.id')
            ->select('structures.name as name', 'cities.name as city', 
            'states.name as state', 'regions.name as region', 'structures.address as address')
            ->where('exams.name', 'LIKE', "%{$exams}%")
            ->groupBy('structures.name')
            ->get();
});