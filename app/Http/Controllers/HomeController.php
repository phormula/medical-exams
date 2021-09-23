<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StructureExam;

class HomeController extends Controller
{
         /**
     * Search for an exam
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('sortBy')){
            $sort = $request->input('sortBy');
        }else{
            $sort = 1;
        }

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
            ->where('exams.name', 'LIKE', "%{$request->get('search')}%")
            ->groupBy('structures.name')
            ->orderBy('structures.premium', 'DESC')
            ->orderBy("{$sort}")
            ->paginate(10);

        //apend $_GET variables to URL
        $structures->appends([
            'search' => $request->get('search'),
            'sortBy' => $sort,
        ]);

        return view('home', compact('structures'));
    }
}
