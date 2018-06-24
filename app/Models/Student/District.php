<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{

    protected $table ='districts';
    
    protected $fillable = [
        'district_name',
        'region',
        'province'
       
    ];

}