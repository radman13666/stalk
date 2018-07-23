<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table ="complains";

    protected $fillable = [
        'title',
        'body',
        'student_name',
        'student_id',
        'status',
    ];
}