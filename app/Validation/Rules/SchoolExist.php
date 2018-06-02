<?php
namespace App\Validation\Rules;

use App\Models\Category\School;
use Respect\Validation\Rules\AbstractRule;

class SchoolExist extends AbstractRule
{
    public function validate($input)
    {
        return School::where('school_name',$input)->count()=== 0;
    }

}