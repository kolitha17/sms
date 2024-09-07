<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvItemDefinition extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'inv_item_definitions';
    protected $fillable = [
        'purchasing_item_id',
        'model',
        'serial_no',
        'status'];



    public function purchasingItem()
    {
        return $this->belongsTo(PurchasingItem::class, 'purchasing_item_id');
    }



}


