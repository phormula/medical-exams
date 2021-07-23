<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Exam;
use App\Models\Cities;
use App\Models\Region;
use App\Models\States;
use App\Models\Structure;
use App\Models\postal_codes;
use Illuminate\Http\Request;
use App\Models\StructureExam;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    public function destroy($id)
    {
        //
    }

    public function getstructure()
    {
        $userStructure = Structure::where('user_id', auth()->id())->first();
        if($userStructure){
            $structure = Structure::query()
                ->join('cities', 'structures.city_id', '=', 'cities.id')
                ->join('states', 'cities.state_id', '=', 'states.id')
                ->join('regions', 'states.region_id', '=', 'regions.id')
                ->join('postal_codes', 'cities.id', '=', 'postal_codes.city_id')
                ->select('structures.name as name', 'cities.id as city', 'postal_codes.code as zip',
                'states.id as state', 'regions.id as region', 'structures.address as address',
                'structures.premium as premium', 'structures.phone as phone')
                ->where('structures.user_id', auth()->id())
                ->get();

            return response()->json($structure);
        }
    }

    public function getstructureexams()
    {
        $structureexam = StructureExam::query()
                        ->join('structures', 'structure_exams.structure_id', 'structures.id')
                        ->join('exams', 'structure_exams.exam_id', 'exams.id')
                        ->where('structures.user_id', auth()->id())
                        ->select('exams.id as id', 'exams.name as ename')
                        ->get();

        return response()->json($structureexam);
    }

    public function getregions()
    {
        $regions = Region::orderBy('name', 'ASC')->get();
        return response()->json($regions);
    }

    public function getexams()
    {
        $exams = Exam::get();
        return response()->json($exams);
    }

    public function findStateWithRegionID($id)
    {
        $state = States::where('region_id', $id)->orderBy('name', 'ASC')->get();
        return response()->json($state);
    }

    public function findCityWithStateID($sID)
    {
        $city = Cities::where('state_id', $sID)->orderBy('name', 'ASC')->get();
        return response()->json($city);
    }

    public function findZipWithCityID($cID)
    {
        $zip = postal_codes::where('city_id', $cID)->get();
        return response()->json($zip);
    }

    public function store(Request $data)
    {
        $s = new Structure();
        $userStructure = Structure::where('user_id', auth()->id())->first();
        if(!$userStructure){
            Structure::create([
                'user_id' => auth()->id(),
                'name' => $data->name,
                'city_id' => $data->city_id,
                'phone' => $data->phone,
                'address' => $data->address,
            ]);
            activity()
                ->performedOn($s)
                ->causedBy(auth()->id())
                ->withProperties(['IpAddress' => $data->ip()])
                ->log('Structure Added');

            return response()->json([
                'status'=>'success',
                'message'=>'Structure added successfully',
            ]);
        }
        else{

            $structure = $s->where('user_id', auth()->id())
                            ->update([
                                'name' => $data->name,
                                'city_id' => $data->city_id,
                                'phone' => $data->phone,
                                'address' => $data->address,
                                'premium' => $data->premium,
                            ]);

            activity()
                ->performedOn($s)
                ->causedBy(auth()->id())
                ->withProperties(['IpAddress' => $data->ip()])
                ->log('Updated structure');

            return response()->json([
                'status'=>'success',
                'message'=>'Structure information updated',
            ]);
        }
    }

    public function saveExams(Request $request)
    {
        $input = $request->all();
        $userStructure = Structure::where('user_id', auth()->id())->first();
        $data = [];
        $data['structure_id'] = json_encode($userStructure->id);
        $data['exam_id'] = json_encode($input['exams']);

        for ($i = 0; $i < count($input['exams']); $i++) {
            $exams[] = [
                'structure_id' => $userStructure->id,
                'exam_id' => $input['exams'][$i],
            ];
        }
        
        StructureExam::where('structure_id', $userStructure->id)->delete();
        StructureExam::insert($exams);

        // StructureExam::create($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Updated',
        ]);
    }
}
