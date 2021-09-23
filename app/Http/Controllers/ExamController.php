<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        return Exam::all();
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
        ]);
        
        Exam::create($fields);
        
        return response()->json([
            'status'=>'success',
            'message'=>'Exam added successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $exam = Structure::find($id);
        $exam->update($request->all());

        return response()->json([
            'status'=>'success',
            'message'=>'Exam updated',
        ]);
    }
}
