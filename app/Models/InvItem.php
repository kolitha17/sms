<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvSubCategory;
use App\Models\InvCategory;
use App\Models\PurchaseOrderInvItem;
use App\Models\InvItemDefinition;

class InvItem extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'inv_items';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'code',
        'ledger_type',
        'status'];

//    one to many relation with SubCategory
    public function subCategory(){
        return $this->hasOne(InvSubCategory::class, 'id', 'sub_category_id');
    }

//    one to many relation with Category
    public function category(){
        return $this->hasOne(InvCategory::class, 'id', 'category_id');
    }

//    one to many relation with PurchaseOrderItem
    public function purOrderInvItems(){
        return $this->hasMany(PurchaseOrderInvItem::class);
    }

    public function purOrder(){
        return $this->belongsToMany(PurchaseOrder::class,'pur_order_inv_items');
    }

//    one to many relation with ItemDefinition
    public function itemDefinitions(){
        return $this->hasMany(InvItemDefinition::class);
    }
}
