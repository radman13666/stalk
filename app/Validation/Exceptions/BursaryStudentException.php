<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class BursaryStudentException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'The Bursary ID and Student name must be the same',
        ]
        ];

}