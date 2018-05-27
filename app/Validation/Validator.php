<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Validator class
 */
class Validator
{
    
    /**
     * Errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Validate class
     *
     * @param [http] $request
     * @param array $rules
     * @return void
     */
    public function validate($request, array $rules)
    {

        foreach( $rules as $field => $rule)
        {
            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
            catch(NestedValidationException $e)
            {
                $this->errors[$field] = $e->getMessages();
            }
    
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    /**
     * Failed method
     *
     * @return void
     */
    public function failed()
    {
        return !empty($this->errors);
    }


}