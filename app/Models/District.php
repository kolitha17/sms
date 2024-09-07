<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use App\Models\OrgUnit;


class District extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'districts';
    protected $fillable = [
        'province_id',
        'name',
        'code'];

//    one to many relation with province
    public function province(){
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

//    when using dynamic relationship
    public function provinces() {

        return $this->belongsTo(Province::class,'id', 'province_id');
    }

//    one to many relation with OrgUnit
    public function orgUnits(){
        return $this->hasMany(OrgUnit::class);
    }
}
