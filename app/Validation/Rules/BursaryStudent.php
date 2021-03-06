<?php
namespace App\Validation\Rules;

use App\Models\Student\Student;
use Slim\Http\Request;
use Respect\Validation\Rules\AbstractRule;

class BursaryStudent extends AbstractRule
{
   
    public function validate($input)
    {
        if(!empty($input))
        {
            $student = Student::where('bursary_id','=',trim($input))->first();

            if(ucwords($student->name)  != ucwords($_POST['name']))
            {
                return false;
            }
            return true;

          
        }

        return true;  
    }

}