<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvSubCategory;


class InvCategory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'inv_categories';
    protected $fillable = [
        'name',
        'code',
        'status'];

//    one to many relation with SubCategories
    public function subCategories(){
        return $this->hasMany(InvSubCategory::class);
    }
}
