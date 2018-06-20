<?php

namespace App\Middleware\Roles;

use App\Middleware\Middleware;

/**
 * This middleware  is for users having  Create  permission
 */
class CrMiddleware extends Middleware
{
    public function __invoke($request,$response,$next)
    {

        if($this->container->auth->permission()->id == 3 ||
           $this->container->auth->permission()->id == 4 ||
           $this->container->auth->permission()->id == 2)
        {
          
        }
        else
        {
            $this->container->flash->addMessage('danger','You do not have permission to perform this action');
            
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }
        $response = $next($request,$response);
        return $response;
        
    }
}