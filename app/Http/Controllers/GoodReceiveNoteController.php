<?php

namespace App\Http\Controllers;

use App\Models\GoodReceiveNote;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderInvItem;
use Illuminate\Http\Request;
use function PHPUnit\Logging\JUnit\name;

class GoodReceiveNoteController extends Controller
{
    protected $grn;
    protected $purchaseOrder;
    protected $purchaseOrderItem;

    public function __construct()
    {
        $this->grn = new GoodReceiveNote();
        $this->purchaseOrder = new PurchaseOrder();
        $this->purchaseOrderItem = new PurchaseOrderInvItem();


    }

    public function index(){

        $response['purchaseOrders'] = $this->purchaseOrder->all();

        return view('pages.form_grn')->with($response);
    }


//    View Items list according to the Purchase Order Number when click ADD button
    public function addItems(Request $request){

        // Retrieve data based on the selected purchase order no
        $poNo = $request->input('po_id');
        dd($poNo);
        $invItem = PurchaseOrderInvItem::where('pur_order_id',$poNo)->get();

        return response()->json(['items'=>$invItem]);

    }

}
