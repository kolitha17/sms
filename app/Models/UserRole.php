<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'um_user_roles';
    protected $fillable = [
        'user_id',
        'role_id'];

    //    one to many relation with User
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    //    one to many relation with Role
    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
