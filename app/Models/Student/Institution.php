<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    
    protected $fillable = [
        'school_id',
        'student_id',
        'course_id',
        'qualification',
        'student_number',
        'registration_number',
        'year_start',
        'year_stop',
        'hostel_id',
        's_form',
        'student_bank_name',
        'student_bank_details',
        'institution_bank_name',
        'institution_bank_details',
        'other_bank_name' ,
        'other_bank_details',
        'created_by'
       
    ];

}