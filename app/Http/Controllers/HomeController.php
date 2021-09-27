<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use App\Models\Exam;
use App\Models\ExamStructure;

class HomeController extends Controller
{
         /**
     * Search for an exam
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $exam = $request->get('search');
        if($request->input('sortBy')){
            $sort = $request->input('sortBy');
        }else{
            $sort = 1;
        }

        $structures = Structure::with('city','state','region')->select('structures.*')
                        ->join('exam_structure', 'structures.id', 'exam_structure.structure_id')
                        ->join('exams', 'exam_structure.exam_id', 'exams.id')
                        ->where('exams.name', 'like', "%$exam%")
                        ->groupBy('structures.id')
                        ->orderByDesc('premium')->paginate(10);

        //apend $requests to URL
        $structures->appends([
            'search' => $request->get('search'),
            'sortBy' => $sort,
        ]);

        return view('home', compact('structures'));
    }
}
