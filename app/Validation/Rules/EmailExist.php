<?php
namespace App\Validation\Rules;

use App\Models\User\User;
use Respect\Validation\Rules\AbstractRule;

class EmailExist extends AbstractRule 
{

    public function validate($input)
    {
    
        return User::where('email','=',$input)->count() === 0;
    }
}