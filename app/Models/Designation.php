<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'um_designation';
    protected $fillable = [
        'name',
        'short_form',
        'designation_status',
        'created_user_id',
    ];
}
