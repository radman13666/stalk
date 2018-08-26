<?php
namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable= [
        'student_id',
        'subject_id',
        'mark',
        'grade',
        'term',
        'academic_year',
        's_form',
        'body',
        'performance',
        'created_id',
        'created_by',
    ];
   

}
