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
            $userStructure = Structure::where('user_id', auth()->id())->first();
            if(!$userStructure){
                Structure::create([
                    'user_id' => auth()->id(),
                    'name' => $data->name,
                    'city_id' => $data->city_id,
                    'phone' => $data->phone,
                    'address' => $data->address,
                ]);

                return response()->json([
                    'status'=>'success',
                    'message'=>'Structure added successfully',
                ]);
            }
            else{
                return response()->json([
                    'status'=>'error',
                    'message'=>'You have already added a Structure',
                ]);
            }
        // }

    }
}
