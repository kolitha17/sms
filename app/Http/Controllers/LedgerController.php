<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    protected $ledger;

    public function __construct()
    {
        $this->ledger = new Ledger();

    }

    public function index(){

//        $response['orgUnits'] = $this->orgUnit->all();

        return view('pages.ledger');
    }
}
