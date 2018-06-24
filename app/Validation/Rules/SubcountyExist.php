<?php
namespace App\Validation\Rules;

use App\Models\Category\Subcounty;
use Respect\Validation\Rules\AbstractRule;

class SubcountyExist extends AbstractRule
{
    public function validate($input)
    {
        return Subcounty::where('subcounty_name',$input)->count()=== 0;
    }

}