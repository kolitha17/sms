<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrgUnit;

class OrgUnitType extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'org_unit_types';
    protected $fillable = [
        'type',
        'level'];

    public function orgUnits(){
        return $this->hasMany(OrgUnit::class);
    }
}
