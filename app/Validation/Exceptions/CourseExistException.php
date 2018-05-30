<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class CourseExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Course already exist but if you can not see it then contact Admin',
        ]
        ];

}