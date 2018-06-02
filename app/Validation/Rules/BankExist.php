<?php
namespace App\Validation\Rules;

use App\Models\Category\Bank;
use Respect\Validation\Rules\AbstractRule;

class BankExist extends AbstractRule
{
    public function validate($input)
    {
        return Bank::where('bank_name',$input)->count()=== 0;
    }

}