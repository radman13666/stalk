<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class SchoolExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'School or Institution already exist',
        ]
        ];

}