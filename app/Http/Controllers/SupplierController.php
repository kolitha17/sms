<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    protected $supplier;

    public function __construct()
    {
        $this->supplier = new Supplier();
    }

    public function index(){

        $response['suppliers'] = $this->supplier->all();
        //dd($this->category->all());
        return view('pages.form_add_supplier')->with($response);
    }

    public function store(Request $request){

        $this->supplier->create($request->all());
        return view('pages.form_add_supplier')->with('success', "Supplier Details Added Successfully");
//        return response()->json([
////            'status' => 200,
//
//        ]);


    }


//  Edit Supplier Details
    public function edit($id){

        return json_encode(Supplier::find($id));

    }

//    Update Supplier Details
    public function update(Request $request){

        $supplier = Supplier::find($request->supplier_id);

        $supplierData  = [
            'id' => $request->supplier_id,
            'name' => $request->supName,
            'address' => $request->supAddress,
            'contact_person' => $request->supContactName,
            'telephone_no' => $request->supTelNo,
            'mobile_no' => $request->supMobNo,
            'email' => $request->supEmail,
        ];

//        dd($supplierData);
        $supplier->update(array_merge($supplier->toArray(),$supplierData));
        return response()->json([
            'status'=>200,
        ]);

    }

    public function delete($id){
        $supp = $this->supplier->find($id);
        $supp->delete();
        return redirect()->back();

    }
}
