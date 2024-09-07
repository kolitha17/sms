<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvCategory;

class InvSubCategory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'inv_sub_categories';
    protected $fillable = [
        'category_id',
        'name',
        'code',
        'status'];

//    one to many relation with Category
    public function category(){
        return $this->hasOne(InvCategory::class, 'id', 'category_id');
    }

//    when using dynamic relationship
    public function invCategory() {

        return $this->belongsTo(InvCategory::class,'id', 'category_id');
    }
}
