<?php
namespace App\Validation\Rules;

use App\Models\Student\Course;
use Respect\Validation\Rules\AbstractRule;

class CourseExist extends AbstractRule
{
    public function validate($input)
    {
        return Course::where('name',$input)->count()=== 0;
    }

}