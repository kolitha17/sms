<?php

namespace App\Http\Controllers;

use App\Models\OrgUnit;
use App\Models\OrgUnitType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $role;

    public function __construct()
    {
        $this->role = new Role();
        $this->orgUnitType = new OrgUnitType();
        $this->orgUnit = new OrgUnit();
        $this->user = new User();
    }

    public function index(){
       $response['roles'] = $this->role->all();
       $response['orgUnitTypes'] = $this->orgUnitType->all();
       $response['orgUnits'] = $this->orgUnit->all();
       $response['users'] = $this->user->all();
       return view ('pages.form_assign_supervisor')->with($response);

    }


    //    load Unit Name
    public function getOrgUnit($org_unit_type_id){
        // Fetch the Org Unit Name from the database based on the Unit Type
        $units = OrgUnit::where('org_unit_type_id', $org_unit_type_id)->get();

        // Return the subcategories as a JSON response
        return response()->json($units);
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
