<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserView;
use Illuminate\Http\Request;
use App\Models\User;

class UserViewController extends Controller
{

     protected $user;

     public function __construct(){

         $this->user = new User();
     }

    public function index(){

        $response['users'] = $this->user->all();
        return view('pages.user_table')->with($response);
    }




}
