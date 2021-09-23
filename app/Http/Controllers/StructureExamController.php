<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\StructureExam;
use Illuminate\Support\Facades\Gate;

class StructureExamController extends Controller
{
    public function store(Request $request, Structure $structure){
        $fields = [
            'structure_id' => $structure->id,
            'exam_id' => $request->exam_id,
        ];

        if (!Gate::allows('manage-structure', $structure)) {
            return response()->json(['error' => 'Not authorized.'],403);
        }

        $row = StructureExam::where($fields)->first();

        if($row === null){
            StructureExam::create($fields);
            return response()->json([
                    'status'=>'success',
                    'message'=>'Structure Exam added successfully',
                ]);
        }
        else{
            return response()->json([
                    'status'=>'fail',
                    'message'=>'Record already exist',
                ]);
        }

    }
}
