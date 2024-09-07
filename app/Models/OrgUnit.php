<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\Province;
use App\Models\OrgUnitType;
use App\Models\User;

class OrgUnit extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'org_units';
    protected $fillable = [
        'org_unit_type_id',
        'province_id',
        'district_id',
        'parent_id',
        'name',
        'remarks'];


    public function district(){
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function province(){
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function parent()
    {
        return $this->belongsTo(OrgUnit::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OrgUnit::class, 'parent_id');
    }

    public function orgUnitType(){
        return $this->hasOne(OrgUnitType::class, 'id', 'org_unit_type_id');
    }

    //    one to many relation with User
    public function users(){
        return $this->hasMany(User::class);
    }

}



