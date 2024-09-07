<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $district;

    public function __construct()
    {
        $this->district = new District();
    }



}
