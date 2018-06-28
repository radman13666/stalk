<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'school_name',
        'school_code',
        'level',
        'district_id',
        'bank_name',
        'bank_account',
        'bank_address',
        'school_address',
        'school_phone',
        'school_email',
        'school_website',
        'created_by',
    ];



}
