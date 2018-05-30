<?php
namespace App\Validation\Rules;

use App\Models\Student\Subject;
use Respect\Validation\Rules\AbstractRule;

class SubjectExist extends AbstractRule
{
    public function validate($input)
    {
        return Subject::where('name',$input)->count()=== 0;
    }

}