<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvCategory;

class InvCategoryController extends Controller
{
    protected $category;

    public function __construct()
    {
        $this->category = new  InvCategory();
    }

    public function index(){
//        get data to view
        $response['categories'] = $this->category->all();
        //dd($this->category->all());
        return view('pages.form_add_category')->with($response);
    }

////   Category Code Generate
//    public function generateCatCode(){
//
//        $lastLetter = InvCategory::orderByDesc('id')->value('code');
//
//        $nextLetter = $lastLetter ? chr(ord($lastLetter) + 1) : 'A';
//
//        // Save the next letter to the database
////        InvCategory::create(['code' => $nextLetter]);
//
//        return view('pages.form_add_category')->with($nextLetter);
//    }

}
