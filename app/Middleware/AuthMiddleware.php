<?php
namespace App\Middleware;

/**
 * Auth Middleware to check if the user is authenticated
 */
class AuthMiddleware extends Middleware
{
    public function __invoke($request,$response,$next)
    {
        if(!$this->container->auth->check())
        {
            return $response->withRedirect($this->container->router->pathFor('auth.login'));
        }
        $response = $next($request,$response);
        return $response;
    }

}