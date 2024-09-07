<?php

namespace App\Http\Controllers;

use App\Models\InvItem;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderInvItem;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Session;
use function Monolog\alert;
use GuzzleHttp\Client;

class PurchaseOrderInvItemController extends Controller
{
    protected $purchaseOrder;
    protected $purchaseOrderInvItem;
    protected $item;

    public function __construct()
    {
        $this->purchaseOrder = new PurchaseOrder();
        $this->purchaseOrderInvItem = new PurchaseOrderInvItem();
        $this->item = new InvItem();

    }

    public function index(){
        $response['items']= $this->item->all();
        $response['purOrderItems'] = $this->purchaseOrderInvItem->all();
        return view('pages.form_add_purchase_order')->with($response);

    }

    public function addItem(Request $request){

    //  calculate Total Amount
        $quntity = $request->input('quantity');
        $uPrice = $request->input('unit_price');
        $vat = $request->input('vat');

        $poItem = new PurchaseOrderInvItem;

        $poItem -> inv_item_id = $request ->input('inv_item_id');
        $poItem -> pur_order_id = $request ->input('pur_order_id');
        $poItem -> quantity = $quntity;
        $poItem -> unit_price = $uPrice;
        $poItem -> vat = $vat;


        //  validate field
        $poItem = $request->validate([
            'inv_item_id' => 'required',
            'pur_order_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'vat' => 'nullable',
            'status' => 'nullable',
            'total_amount' => 'nullable|numeric',
        ]);

        // Set default values if the input is empty
        if (empty($poItem['status'])|| empty($poItem['total_amount'])) {
            $poItem['status'] = 'Pending';
            $poItem['total_amount'] = ($quntity*$uPrice)+$vat;
        }

//        dd($poItem);
//        $poItem->save();
//        return response()->json(['status' => 'success', 'message' => 'Item added successfully']);
        return response()->json($poItem);

    }

//    fetch all Order Items and view in Purchase Order form
        public function fetchAll(Request $request, $po_id){

        $orderData = $request->input('pur_order_no');
        dd($orderData);

    }

    // Temporarily save item details into the Purchase Order form
    public function saveTemp(Request $request){
        // Handle temporary data saving logic
//        $tempData = $request->all();
//        return view('temp-data-display', compact('tempData'));

    }

}
