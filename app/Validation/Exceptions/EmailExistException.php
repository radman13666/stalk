<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email address already exist',
        ]
        ];

}