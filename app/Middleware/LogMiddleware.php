<?php
namespace App\Middleware;

/**
 * 
 * This middleware returns input errors after validation
 * 
 */
class LogMiddleware extends Middleware
{
    
    public function __invoke($request,$response,$next)
    {

        if($this->container->auth->check())
        {
            $this->container->log->updateLog();
            
            $response = $next($request,$response);
            
            return $response;

        }
       
    }

}