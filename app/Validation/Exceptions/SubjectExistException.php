<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class SubjectExistException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Subject exist but if you can not see it then contact Admin',
        ]
        ];

}