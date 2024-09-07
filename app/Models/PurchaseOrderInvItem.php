<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;
use App\Models\InvItem;

class PurchaseOrderInvItem extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'pur_order_inv_items';
    protected $fillable = [
        'pur_order_id',
        'inv_item_id',
        'unit_price',
        'vat',
        'quantity',
        'total_amount',
        'status'];


//    one to many relation with PurchaseOrder
    public function purOrder(){
        return $this->hasOne(PurchaseOrder::class, 'pur_order_id', 'pur_order_id');
    }

//    one to many relation with InventoryItme
    public function invItem(){
        return $this->hasOne(InvItem::class, 'id', 'inv_item_id');
    }



}
