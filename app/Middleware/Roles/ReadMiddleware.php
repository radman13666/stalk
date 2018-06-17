<?php

namespace App\Middleware\Roles;

use App\Middleware\Middleware;

/**
 * This middleware  is for users having read only privillege
 */
class ReadMiddleware extends Middleware
{
    public function __invoke($request,$response,$next)
    {
        
    }
}