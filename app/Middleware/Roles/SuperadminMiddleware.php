<?php

namespace App\Middleware\Roles;

use App\Middleware\Middleware;

/**
 * This middleware  is for users having  Create, Read  and  Update  privilleges
 */
class SuperadminMiddleware extends Middleware
{

    public function __invoke($request,$response,$next)
    {

        if($this->container->auth->user()->role_id != 5)
        {
            $this->container->flash->addMessage('danger','You do not have permission to perform this action');

            return $response->withRedirect($this->container->router->pathFor('dashboard'));
          
        }
        $response = $next($request,$response);
        return $response;
    }
}
