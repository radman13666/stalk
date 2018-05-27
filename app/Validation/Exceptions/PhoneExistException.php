<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PhoneExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Phone number already exist',
        ],
    ];
}