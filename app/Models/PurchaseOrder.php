<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrderInvItem;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'purchase_orders';
    protected $fillable = [
        'supplier_id',
        'bid_no',
        'pur_order_no',
        'po_date',
        'status'];


    //    one to many relation with Purchase Order Inventory Item
    public function purOrderInvItems(){
        return $this->hasMany(PurchaseOrderInvItem::class, 'pur_order_id');
    }

    public function InvItems(){
        return $this->belongsToMany(InvItem::class, 'pur_order_inv_items');
    }



}
