<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\OrgUnit;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\OrgUnitType;
use function Monolog\error;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $designation;
    protected $orgUnitType;
    protected $orgUnit;
    protected $role;

    public function __construct(){

        $this->user = new User();
        $this->designation = new Designation();
        $this->orgUnitType = new OrgUnitType();
        $this->orgUnit = new OrgUnit();
        $this->role = new Role();

    }

    public function index(){

        $response['users'] = $this->user->all();
        $response['designations'] = $this->designation->all();
        $response['orgUnitTypes'] = $this->orgUnitType->all();
        $response['orgUnits'] = $this->orgUnit->all();
        $response['role'] = $this->role->all();


        return view ('pages.user_registration')->with($response);
    }

    //save user details
    public function store(Request $request){

        $data = $request->all();
        $existingRecord = User::where('emp_no', $data['emp_no'])->first();

        if ($existingRecord) {
            // Record already exists, handle it as a duplicate.
            return redirect()->back()->with('fail', 'Sorry! Duplicate Employee Number found.');
        } else {
            // Save the new record.
//            dd($data);
            $this->user->create($data);
            return redirect()->back()->with('success', 'You have Successfully Registered.');
        }



    }


    //get User details for certify registration form
    public function getUserForCertify(){

        $regUsers = User::where(function ($query){
            $query->where('available_status', 'Awaiting')->where('approval_status', 'Pending');
        })->get();

        return view('pages.user_registration_certify', compact('regUsers'));
    }


    //edit registered user for certify
    public function edit($id){

        $response['regUsers'] = $this->user->find($id);
        //$response['roles'] = $this->role->all();
        //$response['roles'] = [name=>'kamal'];
        //$response['role'] = $this->role->all();
        return view('pages.user_registration_certify')->with($response);

    }


    //return view of the Ledger Owner Page
    public function loadLedgerOwner(){

        $response['roles'] = $this->role->all();
        $legOwners = User::where(function ($query){
            $query->where('available_status', 'Awaiting')->where('approval_status', 'Pending');
        })->get();
        return view ('pages.form_assign_ledger_owner',compact('legOwners'))->with($response);

    }

    public function addRole(Request $request){

        $incomingFields = $request->validate([
            'role_id'=>'required',
            'user_id'=>['required']
        ]);

        $newUserRole = UserRole::create($incomingFields);
        return redirect("/user_registration_certify")->with('success','Your post successfully saved');
    }

    //return view of the Ledger Owner Page
    public function loadOperator(){

        $response['roles'] = $this->role->all();
        $operators = User::where(function ($query){
            $query->where('available_status', 'Awaiting')->where('approval_status', 'Pending');
        })->get();
        return view ('pages.form_assign_operator',compact('operators'))->with($response);
    }


    public function loadSurveyors(){

        $response['roles'] = $this->role->all();
        $surveyors = null;
        $surveyors = User::where(function ($query){
            $query->where('designation_id','Government Surveyor')->where('available_status', 'Awaiting')->where('approval_status', 'Pending');
            })->get();
        return view('pages.form_confirm_surveyor',compact('surveyors'))->with($response);
    }

}
