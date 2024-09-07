<?php

namespace App\Http\Controllers;

use App\Models\OrgUnit;
use App\Models\OrgUnitType;
use App\Models\PurchasingItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\InvItem;
use App\Models\InvCategory;
use App\Models\InvSubCategory;
use App\Models\InvItemDefinition;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class PurchasingItemController extends Controller
{

    protected $item;
    protected $category;
    protected $subCategory;
    protected $puchasingItem;
    protected $unitType;
    protected $orgUnit;
    protected $supplier;

    public function __construct(){
        $this->item = new InvItem();
        $this->category = new InvCategory();
        $this->subCategory = new InvSubCategory();
        $this->unitType = new OrgUnitType();
        $this->orgUnit = new OrgUnit();
        $this->supplier = new Supplier();
        $this->puchasingItem = new PurchasingItem();
    }

    public function index(){
        $response['items']= $this->item->all();
        $response['categories']= $this->category->all();
        $response ['subCategories']= $this->subCategory->all();
        $response['unitTypes'] = $this->unitType->all();
        $response['units'] = $this->orgUnit->all();
        $response['suppliers'] = $this->supplier->all();
        return view ('pages.form_purchasing_item')->with($response);
    }

    public function viewPurchaseForm(){
        $response['items']= $this->item->all();
        $response['categories']= $this->category->all();
        $response ['subCategories']= $this->subCategory->all();
        $response['unitTypes'] = $this->unitType->all();
        $response['units'] = $this->orgUnit->all();
        $response['suppliers'] = $this->supplier->all();
        return view('pages.form_purchase')->with($response);
    }


    //    get item list according to SubCategory in the Purchasing Item Form
    public function getItem(Request $request, $subcat_id){

        $item = InvItem::where('sub_category_id', $subcat_id)->get();
        return response()->json($item);

    }

//  get unit list according to unit type in the Purchasing Item Form
    public function getUnit($pur_unit_type){

        $unitslist = OrgUnit::where('org_unit_type_id', $pur_unit_type)->get();

        // Return the subcategories as a JSON response
        return response()->json($unitslist);

    }

//  Save Purchasing Items
    public function store(Request $request){



        $item = new PurchasingItem();
        $item->category_id = $request->input('category_id');
        $item->sub_category_id = $request->input('sub_category_id');
        $item->inv_item_id = $request->input('inv_item_id');
        $item->ledger_no = $request->input('ledger_no');
        $item->ledger_type = $request->input('ledger_type');
        $item->purchase_date = $request->input('purchaseDate');
        $item->pur_unit_type = $request->input('pur_unit_type');
        $item->pur_units = $request->input('pur_units');
        $item->supplier_id = $request->input('supplier_id');
        $item->invoice_no = $request->input('invoiceNo');
        $item->quantity = $request->input('quantity');
        $item->uPrice = $request->input('uPrice');

//save the items
        $item->save();
        $category_id = $request->input('category_id');
        $redirectCategories = [14,16,1];
//        redirecting to relevant page according to categories
        if(in_array($category_id,$redirectCategories)){

            Return redirect()->route('PurchasingItem.viewItemDetailsForm');
        }else{
            return redirect()->route('PurchasingForm.viewPurchaseForm');
        }



//        $rules = [
//            'category_id' => 'required',
//            'sub_category_id' => 'required',
//            'inv_item_id' => 'required',
//            'ledger_no' => 'required',
//            'ledger_type' => 'required',
//            'purchase_date' => 'required|date',
//            'pur_unit_type' => 'required',
//            'pur_units' => 'required',
//            'supplier_id' => 'required',
//            'invoice_no' => 'required',
//            'uPrice' => 'required',
//            'quantity' => 'required|integer|min:1',
//
//        ];
////
//        // Perform validation
//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            // Handle failed validation
//            return redirect('form_purchasing_item')
//                ->withErrors($validator)
//                ->withInput();
//        }else{
//
//
//        }



//        return response()->json([
//            'status'=>200,
//        ]);

//
////        return redirect()->route('PurchasingItem.viewItemDetailsForm');
//        $response = [
//            'success' => true,
//            'message' => 'Data saved successfully',
//            'item' => $item, // Optionally include the saved item in the response
//
//        ];
//
//


//         Return the JSON response
//        return response()->json($response);
    }




// Save Purchasing Items

//   view Item Details Form
    public function viewItemDetailsForm(Request $request){

        $inv_item_id = $request->input('inv_item_id');
        $quantity = $request->input('quantity');


        return view ('pages.form_add_item_details');
    }

    //save btn for purchasing item with model and serial number
    public function saveItemDetails(Request $request)
    {
        $validatedData = $request->validate([ // Lowercase 'v' in 'validate'
            'model' => 'required',
            'serial_no' => 'required',
            'purchasing_item_id' => 'required|exists:purchasing_items,id'

        ]);

        $InvItemDefinition = new InvItemDefinition();
        $InvItemDefinition->model = $validatedData['model'];
        $InvItemDefinition->serial_no = $validatedData['serial_no'];
        $InvItemDefinition->purchasing_item_id = $validatedData['purchasing_item_id'];
        $success = $InvItemDefinition->save();

        if ($success) {
            // If save was successful
            return response()->json(['message' => 'Data Saved Successfully']);
        } else {
            // If save failed
            return response()->json(['message' => 'Failed to save data'], 500);
        }
    }





}


