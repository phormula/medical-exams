<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use App\Models\StructureExam;
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
        return Structure::with('exams:name')->paginate(10);
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
            'city_id' => 'required',
            'phone' => 'required',
            'address' => 'required'
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
        return Structure::with('exams:name')->where('id', "{$id}")->get();
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
        if (!Gate::allows('manage-structure', $structure)) {
            return response()->json(['error' => 'Not authorized.'],403);
        }
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
        if (!Gate::allows('manage-structure', $structure)) {
            return response()->json(['error' => 'Not authorized.'],403);
        }
        Structure::destroy($structure->id);

        return response()->json([
            'status'=>'success',
            'message'=>'Structure deleted',
        ]);
    }

     /**
     * Search for an exam
     *
     * @param  str  $string
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $string)
    {
        ($request->input('sortBy')) ? $sort = $request->input('sortBy') : $sort = '';

        return StructureExam::query()
        ->join('exams', 'structure_exams.exam_id', '=', 'exams.id')
        ->join('structures', 'structure_exams.structure_id', '=', 'structures.id')
        ->join('cities', 'structures.city_id', '=', 'cities.id')
        ->join('states', 'cities.state_id', '=', 'states.id')
        ->join('regions', 'states.region_id', '=', 'regions.id')
        ->join('postal_codes', 'cities.id', '=', 'postal_codes.city_id')
        ->select('structures.name as name', 'cities.name as city', 'postal_codes.code as zip',
        'states.name as state', 'regions.name as region', 'structures.address as address',
        'structures.premium as premium')
        ->where('exams.name', 'LIKE', "%{$string}%")
        ->groupBy('structures.name')
        ->orderBy('structures.premium', 'DESC')
        ->orderBy("{$sort}")
        ->paginate(10);
    }
}
