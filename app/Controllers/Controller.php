<?php

namespace App\Controllers;

/**
 * This is the base controller
 */
class Controller 

{
    protected $container;

    /**
     * Constructor
     *
     * @param [type] $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Getting view property
     *
     * @param [string] $property
     * @return void
     */
    public function __get($property)
    {
        if($this->container->{$property})
        {
            return $this->container->{$property};
        }
    }
}