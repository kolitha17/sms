<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'description',
        'status'];

    //    one to many relation with User Roles
    public function userRoles(){
        return $this->hasMany(UserRole::class);
    }
}
