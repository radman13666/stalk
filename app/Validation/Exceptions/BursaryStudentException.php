<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class BursaryStudentException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Student name does not match the  Bursary ID',
        ]
        ];

}