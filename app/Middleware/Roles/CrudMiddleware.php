<?php

namespace App\Middleware\Roles;

use App\Middleware\Middleware;

/**
 * This middleware  is for users having read only privillege
 */
class CrudMiddleware extends Middleware
{
    public function __invoke($request,$response,$next)
    {

        // if($this->container->auth->permission()->id != 4)
        // {
        //     $this->container->flash->addMessage('danger','You do not have permission to access this page');

        //     return $response->withRedirect($this->container->router->pathFor('dashboard'));
        // }
        $response = $next($request,$response);
        return $response;
        
    }
}