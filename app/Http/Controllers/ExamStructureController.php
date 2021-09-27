<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\ExamStructure;
use Illuminate\Support\Facades\Gate;

class ExamStructureController extends Controller
{
    public function store(Request $request, Structure $structure)
    {
        $exams = explode(',', $request->exam_id);

        for ($i = 0; $i < count($exams); $i++) {
            ExamStructure::firstOrCreate([
                'structure_id' => $structure->id,
                'exam_id' => $exams[$i],
            ]);
        }

        return response()->json([
                'status'=>'success',
                'message'=>'Structure Exam added successfully',
            ]);

    }

    public function destroy(Request $request, Structure $structure)
    {
        $exams = explode(',', $request->exam_id);

        for ($i = 0; $i < count($exams); $i++) {
            ExamStructure::firstWhere([
                'structure_id' => $structure->id,
                'exam_id' => $exams[$i],
            ])->delete();
        }

        return response()->json([
                'status'=>'success',
                'message'=>'Structure Exam deleted',
            ]);
    }
}
