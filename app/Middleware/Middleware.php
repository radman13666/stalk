<?php
namespace App\Middleware;

/**
 * Based middleware
 */
class Middleware
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


}