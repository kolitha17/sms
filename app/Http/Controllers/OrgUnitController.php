<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\OrgUnitType;
use App\Models\OrgUnit;
use App\Models\Province;
use Illuminate\Http\Request;

class OrgUnitController extends Controller
{
    protected $orgUnitType;
    protected $orgUnit;
    protected $district;
    protected $province;

    public function __construct()
    {
        $this->orgUnit = new OrgUnit();
        $this->orgUnitType = new OrgUnitType();
        $this->district = new District();
        $this->province = new Province();
    }

    public function index(){

        $response['orgUnits'] = $this->orgUnit->all();
        $response['orgUnitTypes'] = $this->orgUnitType->all();
        $response['provinces'] = $this->province->all();
        $response['districts'] = $this->district->all();
        return view('pages.org_unit')->with($response);
    }

//  save unit details
    public function store(Request $request){

//        dd($request->all());
        $this->orgUnit->create($request->all());
        return redirect()->back();
    }


//  edit Unit details
    public function editOrgUnit($id){

        return json_encode(OrgUnit::find($id));
    }

//  update Unit details
    public function updateOrgUnit(Request $request){

        $orgUnit = OrgUnit::find($request->orgUnit_id);

        $orgUnitData  = [
            'id' => $request->orgUnit_id,
            'org_unit_type_id' => $request->unitType,
            'province_id' => $request->province,
            'district_id' => $request->district,
            'parent_id' => $request->supervisorUnit,
            'name' => $request->unitName,
        ];

        $orgUnit->update(array_merge($orgUnit->toArray(), $orgUnitData));
        return response()->json([
            'status'=>200,
        ]);

    }

//    load District
    public function getProvince($province_id){
        // Fetch the districts from the database based on the province_id
        $districts = District::where('province_id', $province_id)->get();

        // Return the subcategories as a JSON response
        return response()->json($districts);
    }

//    load OfficeName
    public function getOfficeName($office_type){
        // Fetch the office name from the database based on the office type
        $officeName = OrgUnit::where('org_unit_type_id', $office_type)->get();

        // Return the subcategories as a JSON response
        return response()->json($officeName);
    }



}
