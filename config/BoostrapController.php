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

// Subject Controller

$container['SubjectController'] = function($container){
    return new \App\Controllers\Student\SubjectController($container);
};

// course controller
$container['CourseController'] = function($container){
    return new \App\Controllers\Student\CourseController($container);
};

// Student controller
$container['StudentController'] = function($container){
    return new \App\Controllers\Student\StudentController($container);
};

// Secondary controller
$container['SecondaryController'] = function($container){
    return new \App\Controllers\Student\SecondaryController($container);
};

// School controller
$container['SchoolController'] = function($container){
    return new \App\Controllers\Category\SchoolController($container);
};