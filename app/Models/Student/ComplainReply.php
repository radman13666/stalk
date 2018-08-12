<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class ComplainReply extends Model
{
    protected $table ="complain_reply";

    protected $fillable = [
        'complain_id',
        'user_id',
        'student_id',
        'message',
    ];
}