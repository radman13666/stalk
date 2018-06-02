<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class BankExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Bank already exist',
        ]
        ];

}