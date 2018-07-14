<?php
namespace App\Validation\Rules;

use App\Models\Student\Student;
use Respect\Validation\Rules\AbstractRule;

class Bursaryid extends AbstractRule
{
    public function validate($input)
    {
        if(!empty($input))
        {
             return  Student::where('bursary_id','=',$input)->count() > 0;

          
        }

        return true;  
    }

}