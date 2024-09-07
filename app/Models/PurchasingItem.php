<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingItem extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'purchasing_items';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'inv_item_id',
        'ledger_type',
        'purchase_date',
        'pur_unit_type',
        'pur_units',
        'ledger_no',
        'supplier_id',
        'invoice_no',
        'quantity',
        'uPrice',
        'status'];

    //    one to many relation with InventoryItem
    public function invItem(){
        return $this->hasOne(InvItem::class, 'id', 'inv_item_id');
    }

    //    one to many relation with SubCategory
    public function subCategory(){
        return $this->hasOne(InvSubCategory::class, 'id', 'sub_category_id');
    }

//    one to many relation with Category
    public function category(){
        return $this->hasOne(InvCategory::class, 'id', 'category_id');
    }
// one to many relationship with item definition
    public function invItemDefinitions()
    {
        return $this->hasMany(InvItemDefinition::class, 'purchasing_item_id');
    }


}
