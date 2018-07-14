<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class BursaryidException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Student Bursary ID does not exist',
        ]
        ];

}