<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    protected $province;

    public function __construct()
    {
        $this->province = new Province();
    }

//    load province dropdown list
    public function index(){
        $response['provinces'] = $this->province->all();
        dd($this->province->all());
//        return view('pages.org_unit')->with($response);
    }
}
