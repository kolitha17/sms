<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'telephone_no',
        'mobile_no',
        'email',
        'status'];
}
