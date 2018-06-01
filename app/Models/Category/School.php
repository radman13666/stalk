<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'school_code',
        'level',
        'about',
        'created_by'
    ];

}
