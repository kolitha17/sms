<?php

namespace App\Http\Controllers;

use App\Models\InvSubCategory;
use App\Models\InvCategory;
use App\Models\PurchaseOrderInvItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use function Illuminate\Process\input;

class PurchaseOrderController extends Controller
{
    protected $purchaseOrder;
    protected $category;
    protected $subCategory;
    protected $supplier;

    public function __construct()
    {
        $this->purchaseOrder = new PurchaseOrder();
        $this->subCategory = new InvSubCategory();
        $this->category = new InvCategory();
        $this->supplier = new Supplier();
        $this->purchaseOrderItem = new  PurchaseOrderInvItem();
    }

    public function index(){

        $response['categories']= $this->category->all();
        $response ['subCategories']= $this->subCategory->all();
        $response ['suppliers'] = $this->supplier->all();
        $response ['purchaseOrders'] = $this->purchaseOrder->all();
        return view('pages.form_add_purchase_order')->with($response);
    }

    public function store(Request $request){
//        $this->purchaseOrder->create($request->all());

        $this->validate($request,[
            'supplier_id'=>'required',
            'bid_no'=>'required',
            'pur_order_no'=>'required',
            'po_date'=>'required',

        ]);


        // Create a new Purchase Order
        $purchaseOrder = PurchaseOrder::create([
            'supplier_id' => $request->input('supplier_id'),
            'bid_no' => $request->input('bid_no'),
            'pur_order_no' => $request->input('pur_order_no'),
            'po_date' => $request->input('po_date'),
            'status'=> 'active',
        ]);

//        dd($purchaseOrder);

        // Save data to invoice_item_table for dynamically added items
        $item_id = $request->input('inv_item_id');
        $quantity = $request->input('quantity');
        $unit_price = $request->input('unit_price');
        $vat = $request->input('vat');
        $amount = $request->input('total_amount');


        try {
            foreach ($item_id as $key => $id) {
                $purchaseOrder->PurchaseOrderInvItem()->create([
                    'pur_order_id' => $purchaseOrder->pur_order_no, // Set the foreign key value
                    'inv_item_id' => $id,
                    'quantity' => $quantity[$key],
                    'unit_price' => $unit_price[$key],
                    'vat' => $vat[$key],
                    'total_amount' => $amount[$key],

                ]);
            }

            return redirect('pages.form_add_purchase_order')->with('success', 'Purchase Order Item has been successfully inserted.');
        } catch (\Exception $e) {
            // Handle any errors that occur during the process
            return redirect()->back()->with('error', 'An error occurred while saving the purchase order: ' . $e->getMessage());
        }
    }




    public function getOrderItems($purchaseOrderId){

        $purchaseOrder = PurchaseOrderInvItem::find($purchaseOrderId);

        $orderItems = $purchaseOrder->orderItems;

        return response()->json($orderItems);
    }




}
