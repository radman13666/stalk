<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Student extends Model 
{

    protected $fillable = [
       
        'name' ,
        'dob',
        'level',
        'gender', 
        'ethnicity',
        'entry_grade',
        'student_phone',
        'student_email',
        'parent1_name',
        'parent1_phone',
        'parent2_name',
        'parent2_email',
        'district',
        'subcounty',
        'village',
        'current_state',
        'dropout_reason',
        'notes',
        'deleted_by',
        'deleted_at',
        'deleted',
        'created_by',
        'created_id'

    ];

}