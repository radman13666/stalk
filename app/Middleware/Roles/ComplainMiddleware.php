<?php
namespace App\Middleware\Roles;

use App\Middleware\Middleware;

class  ComplainMiddleware extends Middleware
{

/**
 * This middleware  for managing complains privilleges
 */

    public function __invoke($request,$response,$next)
    {
        if(!$this->container->auth->check())
        {
            $this->container->flash->addMessage('danger','Please login');
            
            return $response->withRedirect($this->container->router->pathFor('auth.login'));
        }


        if($this->container->auth->permission()->id !=  in_array($this->container->auth->permission()->id,[6,4]))
        {
            $this->container->flash->addMessage('danger','You do not have permission to perform this action');

            return $response->withRedirect($this->container->router->pathFor('dashboard'));
          
        }
        $response = $next($request,$response);
        return $response;

    }

}