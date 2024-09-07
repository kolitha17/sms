<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use Hash;
use Session;

class CustomAuthController extends Controller
{

    public function login(){
        return view('pages.login');
    }
    public function registration(){
        return view('pages.user_registration');
    }
    public function registerUser(Request $request){
        $request->validate([
            'emp_no'=>'required|min:4|max:5',
            'full_name'=>'required',
            'designation'=>'required',
            'email_address'=>'required|email|unique:um_user',
            'mobile_no'=>'required',
            'office_type'=>'required',
            'office_name'=>'required',
            'user_name'=>'required|min:4|max:15',
            'password'=>'required|confirmed|min:5|max:12'
        ]);

        $user = new User();
        $user->emp_no = $request->emp_no;
        $user->full_name = $request->full_name;
        $user->designation_id = $request->designation;
        $user->email_address = $request->email_address;
        $user->mobile_no = $request->mobile_no;
        $user->office_type = $request->office_type;
        $user->org_unit_id = $request->office_name;
        $user->user_name = $request->user_name;
        $user->password = Hash::make($request->password);
        $res = $user->save();
        if($res){
            return back()->with('success','You have Successfully Registered!');
        }else{
            return back()->with('fail','sorry..!');
        }
    }


    public function loginUser(Request $request){
        $request->validate([
            'user_name'=>'required|min:4|max:15',
            'password'=>'required|min:5|max:12'
        ]);

        $user = User::where('user_name','=',$request->user_name)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $request-> session()->put('loginId',$user->id);

                return redirect()->route('dashboard');
                //return redirect('/dashboard');
                //return view('pages.home');
            }else{
                return back()->with('fail','Password Not Match.');
            }
        }else{
            return back()->with('fail','This user name is invalid.');
        }
    }

    public function dashboard(){
        $data = array();
        if(session::has('loginId')){
            $data = User::where('id','=',session::get('loginId'))->first();
        }
         return view('pages.home',compact('data'));

    }

    public function logout(){
        return "Logout";
    }
}
