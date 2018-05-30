<?php
namespace App\Middleware;

/**
 * Guest Middleware
 */
class GuestMiddleware extends Middleware
{
    public function __invoke($request,$response,$next)
    {
        if($this->container->auth->check())
        {
            
            return $response->withRedirect($this->container->router->pathFor('user.index'));
        }
        $response = $next($request,$response);
        return $response;
    }

}