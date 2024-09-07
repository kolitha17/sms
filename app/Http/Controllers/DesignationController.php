<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    protected $designation;

    public function __construct(){

        $this->designation = new Designation();
    }


    public function index(){

    }
}
