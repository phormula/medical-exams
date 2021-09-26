<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\StructureExam;
use Illuminate\Support\Facades\Gate;

class StructureExamController extends Controller
{
    public function store(Request $request, Structure $structure){

        $exams = explode(',', $request->exam_id);

        for ($i = 0; $i < count($exams); $i++) {
            StructureExam::firstOrCreate([
                'structure_id' => $structure->id,
                'exam_id' => $exams[$i],
            ]);
        }

        return response()->json([
                'status'=>'success',
                'message'=>'Structure Exam added successfully',
            ]);

    }
}
