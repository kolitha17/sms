<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvCategory;
use App\Models\InvSubCategory;

class InvSubCategoryController extends Controller
{
    protected $subCategory;
    protected $category;

    public function __construct()
    {
        $this->subCategory = new InvSubCategory();
        $this->category = new InvCategory();
    }


    public function index(){

        $response ['subCategories']= InvSubCategory::all();
        $response['categories']= $this->category->all();
//        dd($this->category->all());
        return view('pages.form_add_sub_category')->with($response);


    }

    public function edit($subCategoryId) {
        $subCat = InvSubCategory::find($subCategoryId);
        return view('pages.form_edit_sub_category', compact('subCat'));
    }


}
