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
        'school_code',
        'year_start',
        'year_stop',
        'bank',
        'bank_address',
        'bank_account',
        'fav_subject',
        'fav_sport',
        'first_term',
        'second_term',
        'third_term',
        'draft',
        'deleted_at',
        'deleted_by',
        'deleted',
        'created_by'
    ];

}