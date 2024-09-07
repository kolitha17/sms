<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvItem;
use App\Models\InvCategory;
use App\Models\InvSubCategory;


class InvItemController extends Controller
{
    protected $item;
    protected $category;
    protected $subCategory;

    public function __construct(){

        $this->item = new InvItem();
        $this->category = new InvCategory();
        $this->subCategory = new InvSubCategory();
    }


    public function index(){

        $response['items']= InvItem::all();
        $response['categories']= $this->category->all();
        $response ['subCategories']= $this->subCategory->all();
        // dd($this->item->all());
        return view ('pages.form_add_item')->with($response);

    }

//   Category data
    //load category into dropdown list
    public function create(){
        $categories = InvCategory::all();
        return view('pages.form_add_item', compact('categories'));
    }

//   Category Code Generate
    public function generateCatCode(){

        $lastLetter = InvCategory::orderByDesc('id')->value('code');

        $nextLetter = $lastLetter ? chr(ord($lastLetter) + 1) : 'A';

        if(!InvCategory::where('code',$nextLetter)->exists()){
            // Save the next letter to the database
            InvCategory::create(['code' => $nextLetter]);
        }

//       return view('pages.form_add_category')->with('nextLetter', $nextLetter);
        return response()->json(['nextLetter' => $nextLetter]);

    }

//    edit available category data
    public function edit($id){

        return json_encode(InvCategory::find($id));
//        $response['category'] = $this->category->find($id);
//        return view('pages.form_edit_category')->with($response);
    }


//    update category data
    public function update(Request $request){
        $category = InvCategory::find($request->cat_id);

        $catData  = [
            'id' => $request->cat_id,
            'name' => $request->name,
            'code' => $request->code,
        ];


        $category->update(array_merge($category->toArray(),$catData));

        return response()->json([
            'status'=>200,
        ]);
    }


//    delete category data from the table
    public function delete($id){

        $category = $this->category->find($id);
        $category->delete();
        return redirect()->back();
    }


//save category data
    public function categoryStore(Request $request){

//        validate field
        $validatedData = $request->validate([
            'name' => 'required|max:150',
            'code' => 'required|max:5',
            // Add more validation rules for other fields if necessary.
        ]);

        // Check for duplicates
        $existingCategory = $this->category->where('name', $validatedData['name'])->first();
//        dd($request);

        if ($existingCategory) {
            // Handle the duplicate value as needed (update, skip, raise an error, etc.)
            // For example, you can redirect back with an error message.
            return redirect()->back()->with('fail', 'Sorry! Duplicate Category Name found.');
        }

        // No duplicates found, proceed with creating the new category
        $this->category->create($validatedData);
//        $this->category->create($request->all());
        // After creating the category, you can redirect the user back to the previous page or any other desired page.
        return redirect()->back()->with('success', 'Category inserted successfully.');
    }




//Sub Category Data
// save Sub Category data into the database
    public function subCategoryStore(Request $request){
//      concatinate Category and SubCategory Code
        $catCode = $request->input('catCode');
        $subCode = $request->input('code');
        $subCategoryCode = $catCode.''.$subCode;

        $subCategory = new InvSubCategory();
        $subCategory->category_id = $request->input('category_id');
        $subCategory->name = $request->input('name');
        $subCategory->code = $subCategoryCode;

//        check for already exist
        $existingSubCategory = $this->subCategory->where('category_id',$subCategory['category_id'])
                                                 ->where('name',$subCategory['name'])
                                                 ->where('code',$subCategory['code'])->first();

        if ($existingSubCategory) {
            // Record already exists, handle it as a duplicate.
            return redirect()->back()->with('fail', 'Sorry! Duplicate Sub Category found.');
        } else {
            // Save the new record.

            $subCategoryArray = $subCategory->toArray();
            $this->subCategory->create($subCategoryArray);
            return redirect()->back()->with('success', 'Sub Category has successfully inserted.');
        }


    }


//    edit available SubCat data
    public function editSubCategory($id){

      return json_encode(InvSubCategory::find($id));

    }



//    Update SubCategory
    public function updateSubCat(Request $request){
        $subcategory = InvSubCategory::find($request->subCat_id);
//        return response()->json($subcategory);

        $subCatData  = [
            'id' => $request->subCat_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'code' => $request->code,
        ];


        $subcategory->update(array_merge($subcategory->toArray(),$subCatData));

        return response()->json([
            'status'=>200,
        ]);

    }






//    Item Data
// save item data
    public function itemStore(Request $request){

//   concatinate SubCategory and Item Code
        $subCode = $request->input('subCode');
        $itemCode = $request->input('code');
        $fullItemCode = $subCode.''.$itemCode;

//        dd($fullItemCode);

        $item = new InvItem();
        $item->category_id = $request->input('category_id');
        $item->sub_category_id = $request->input('sub_category_id');
        $item->name = $request->input('name');
        $item->code = $fullItemCode;
        $item->ledger_type = $request->input('ledger_type');
        $item->save();

        return redirect()->back()->with('success','Inventory Item inserted successfully.');

    }

//    Edit Item Data
    public function itemEdit($id){

        return json_encode(InvItem::find($id));

    }

//    Update Item Data
    public function itemUpdate(Request $request){

//        $item = $this->item->find($id);
        $item = InvItem::find($request->item_id);

        $itemData  = [
            'id' => $request->item_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'code' => $request->code,
            'ledger_type' => $request->ledger_type,
        ];

//        dd($subCatData);
        $item->update(array_merge($item->toArray(),$itemData));
        return response()->json([
            'status'=>200,
        ]);
    }

//    Delete Item Data
    public function itemDelete($id){
        $item = $this->item->find($id);
        $item->delete();
        return redirect()->back();
    }


//  get category code from db into the SubCategory Form
    public function getCatCode($category_id){

        $category = InvCategory::where('id', $category_id)->first();
        return response()->json([$category]);

    }

//    get subCategory list according to Category in the Item Form
    public function getCategoryCode(Request $request, $category_id){
//        dd($category_id);

        // Fetch the subcategories from the database based on the category_id
        $subCategories = InvSubCategory::where('category_id', $category_id)->get();

        // Return the subcategories as a JSON response
        return response()->json($subCategories);
    }



//    get item list according to SubCategory in the Purchase Order Item Form
    public function getSubCatCode(Request $request, $sub_category_id){

        $item = InvItem::where('sub_category_id', $sub_category_id)->get();
        return response()->json($item);

    }



    public function getSubCategoryCode(Request $request, $sub_category_id){

        $subCatCode = InvSubCategory::where('id', $sub_category_id)->get();
        return response()->json($subCatCode);

    }




}
