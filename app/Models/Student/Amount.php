<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    protected $table ="amount";

    protected $fillable = [
        'student_id',
        'amount',
        'reason',
        'form',
        'bank',
        'year',
        'term',
        'created_by'
    ];
}