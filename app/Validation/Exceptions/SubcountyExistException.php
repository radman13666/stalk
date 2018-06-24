<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class SubcountyExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Subcounty already exist',
        ]
        ];

}