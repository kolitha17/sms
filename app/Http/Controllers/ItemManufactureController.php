<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemManufacture;

class ItemManufactureController extends Controller
{
    protected $manufacture;

    public function __construct()
    {
        $this->manufacture = new ItemManufacture();
    }

    public function index(){

        $response['manufactures'] = $this->manufacture->all();
        return view('pages.item_manufacture')->with($response);
    }

    // Save category data into the database
    public function store(Request $request){

        $this->manufacture->create($request->all());
        return redirect()->back();

    }

//    Edit Manufacture
    public function edit($id){

        return json_encode(ItemManufacture::find($id));

    }

//    Update Manufacture
    public function update(Request $request){

        $manufacture = ItemManufacture::find($request->manufacture_id);

        $manufactureData  = [
            'id' => $request->manufacture_id,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
        ];

//        dd($subCatData);
        $manufacture->update(array_merge($manufacture->toArray(),$manufactureData));
        return response()->json([
            'status'=>200,
        ]);

    }

    public function delete($id){

        $manufacture = $this->manufacture->find($id);
        $manufacture->delete();
        return redirect()->back();

    }

}
