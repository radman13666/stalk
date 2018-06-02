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
        'about',
        'created_by'
    ];

}
