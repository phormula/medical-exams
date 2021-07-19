<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StructureExam;

class StructuresController extends Controller
{

    public function search(Request $request){
        
        $exams = $request->input('search');

        $structures = StructureExam::query()
            ->join('exams', 'structure_exams.exam_id', '=', 'exams.id')
            ->join('structures', 'structure_exams.structure_id', '=', 'structures.id')
            ->join('cities', 'structures.city_id', '=', 'cities.id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->join('regions', 'states.region_id', '=', 'regions.id')
            ->select('structures.name as name', 'cities.name as city', 'states.name as state', 'regions.name as region')
            ->where('exams.name', 'LIKE', "%{$exams}%")
            ->get();

        return view('search', compact('structures'));
    }

}
