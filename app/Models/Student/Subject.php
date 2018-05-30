<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = [
        'name',
        'category',
        'deleted_by',
        'deleted',
        'deleted_at'
    ];
}