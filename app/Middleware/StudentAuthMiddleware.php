<?php
namespace App\Middleware;

/**
 * Auth Middleware to check if the user is authenticated
 */
class StudentAuthMiddleware extends Middleware
{
    public function __invoke($request,$response,$next)
    {
        if(!$this->container->auth->isStudent())
        {
            return $response->withRedirect($this->container->router->pathFor('auth.student'));
        }
        $response = $next($request,$response);
        return $response;
    }

}