<?php
namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Secondary extends Model
{
    protected $table ='secondary';

    protected $fillable = [

        'school_id',
        's_form',
        'stream',
        'subjects',
        'student_id',
        'student_number',
        'student_index',
        'fav_subject',
        'fav_sport',
        'draft',
        'deleted_at',
        'deleted_by',
        'deleted',
        'created_by'
    ];

}