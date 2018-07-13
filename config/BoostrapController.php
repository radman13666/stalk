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
// my subject controller

$container['MysubjectController'] = function($container){
    return new \App\Controllers\Category\MysubjectController($container);
};

// course controller
$container['CourseController'] = function($container){
    return new \App\Controllers\Student\CourseController($container);
};

// Student controller
$container['StudentController'] = function($container){
    return new \App\Controllers\Student\StudentController($container);
};


// Draft controller
$container['DraftController'] = function($container){
    return new \App\Controllers\Student\DraftController($container);
};

// Secondary controller
$container['SecondaryController'] = function($container){
    return new \App\Controllers\Student\SecondaryController($container);
};

// School controller
$container['SchoolController'] = function($container){
    return new \App\Controllers\Category\SchoolController($container);
};

// Bank controller
$container['BankController'] = function($container){
    return new \App\Controllers\Category\BankController($container);
};

// Hostel controller
$container['HostelController'] = function($container){
    return new \App\Controllers\Category\HostelController($container);
};

// Institution controller
$container['InstitutionController'] = function($container){
    return new \App\Controllers\Student\InstitutionController($container);
};

// Change Password controller
$container['ChangePasswordController'] = function($container){
    return new \App\Controllers\Setting\ChangePasswordController($container);
};

// Generate report
$container['ReportController'] = function($container){
    return new \App\Controllers\Report\ReportController($container);
};

// subcounty controllers
$container['SubcountyController'] = function($container){
    return new \App\Controllers\Category\SubcountyController($container);
};

// results controller
$container['ResultController'] = function($container){
    return new \App\Controllers\Student\ResultController($container);
};

// Amount controller
$container['AmountController'] = function($container){
    return new \App\Controllers\Student\AmountController($container);
};


/***
 * 
 * Super Admin  controllers
 */

 // student controller
$container['StudentTrashController'] = function($container){
    return new \App\Controllers\Superadmin\StudentTrashController($container);
};


/*****************************************************************************
 * 
 * Api Controllers
 * 
 ******************************************************************************/

 $container['AuthApiController'] = function($container){
    return new \App\Api\AuthApiController($container);   
 };