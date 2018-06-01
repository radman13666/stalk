<?php
namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    protected $table ='student_subjects';

    protected $fillable = [
        'student_id',
        'subject_id'
    ];

}