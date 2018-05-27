<?php

/**
 * This contains all  controllers
 * 
 */
$container['RegistrationController'] = function($container){
    return new \App\Controllers\Auth\RegistrationController($container);
};

$container['HomeController'] = function($container){
    return new \App\Controllers\HomeController($container);
};

$container['LoginController'] = function($container){
    return new \App\Controllers\Auth\LoginController($container);
};

$container['UserController'] = function($container){
    return new \App\Controllers\User\UserController($container);
};