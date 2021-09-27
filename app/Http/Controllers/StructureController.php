<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\ExamStructure;
use Illuminate\Support\Facades\Gate;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Structure::with('exams:name', 'city', 'state', 'region')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'city_id' => 'required|integer',
            'phone' => 'required',
            'address' => 'required',
            'premium' => 'boolean',
        ]);
        $fields['user_id'] = auth()->id();
        
        Structure::create($fields);

        return response()->json([
            'status'=>'success',
            'message'=>'Structure added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Structure::with('exams:name', 'city', 'state', 'region')
                ->where('id', "{$id}")->get();
    }

    /**
     * Display user specified resources.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function userStructure($userId)
    {
        return Structure::with('exams:name')->where('user_id', "{$userId}")->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Structure $structure)
    {
        $s = Structure::find($structure->id);
        $s->update($request->all());

        return response()->json([
            'status'=>'success',
            'message'=>'Structure information updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Structure $structure)
    {
        Structure::destroy($structure->id);

        return response()->json([
            'status'=>'success',
            'message'=>'Structure deleted',
        ]);
    }

}
