<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $fillable = [
        'name',
        'category',
        'level',
        'deleted_by',
        'deleted',
        'deleted_at'
    ];
}