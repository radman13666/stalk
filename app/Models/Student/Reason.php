<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    
    protected $fillable = [
        'reason',
        'student_name',
        'bursary_id',
        'user_name',
        'user_id',
       
    ];

}