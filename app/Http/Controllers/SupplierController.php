<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


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

        $incomingFields = $request->validate([
            'name'=>['required','min:6','max:20'],
            'address'=>['required'],
            'contact_person'=>['required'],
            'telephone_no'=>['required'],
            'mobile_no'=>['required'],
            'email'=>['required','email']
        ]);

        $supplier = Supplier::create($incomingFields);

        $suppliers = $this->supplier->all();
        return view('pages.form_add_supplier',compact('suppliers'))->with('success', "Supplier Details Added Successfully");

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
