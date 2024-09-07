<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    protected $table = 'um_user';
    protected $fillable = [
        'full_name',
        'emp_no',
        'designation_id',
        'mobile_no',
        'email_address',
        'email_verified_at',
        'user_name',
        'password',
        'org_unit_id',
        'available_status',
        'status_updated_user_id',
        'approval_status',
        'approval_user_id',
        'user_image',
        'last_login',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //    one to many relation with OrgUnit
    public function orgUnit(){
        return $this->hasOne(OrgUnit::class, 'id', 'org_unit_id');
    }

    //    one to many relation with User Roles
    public function userRoles(){
        return $this->hasMany(UserRole::class);
    }

}
