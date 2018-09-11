<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Student extends Model 
{

    protected $dates = ['dob','year_start'];

    protected $fillable = [
       'bursary_id',
        'name' ,
        'dob',
        'level',
        'gender', 
        'ethnicity',
        'national_id',
        'registration_year',
        'year_start',
        'year_stop',
        'uce_grade',
        'uace_grade',
        'entry_grade',
        'student_phone',
        'student_email',
        'parent1_name',
        'parent1_phone',
        'parent2_name',
        'parent2_phone',
        'district',
        'dist_name',
        'subcounty',
        'village',
        'current_state',
        'dropout_reason',
        'comments',
        'notes',
        'school',
        's_form',
        'funder',
        'health',
        'photo',
        'draft',
        'deleted_by',
        'deleted_at',
        'deleted',
        'created_by',
        'created_id'

    ];

}