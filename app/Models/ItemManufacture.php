<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemManufacture extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'item_manufactures';
    protected $fillable = [
        'name',
        'address',
        'email',
        'contact_no',
        'status'];

//    one to many relation with ItemDefinition
    public function itemDefinitions(){
        return $this->hasMany(InvItemDefinition::class);
    }
}
