<?php
namespace App\Validation\Rules;

use App\Models\User\User;
use Respect\Validation\Rules\AbstractRule;

class PhoneExist extends AbstractRule
{
    public function validate($input)
    {
        return User::where('phone',$input)->count()=== 0;
    }

}