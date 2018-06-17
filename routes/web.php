<?php

/**
 * 
 * This contains all the web routes
 * 
 */

use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;



$app->group('',function(){
    $this->get('/','LoginController:index')->setName('auth.login');
    $this->post('/','LoginController:authenticate');
})->add( new GuestMiddleware($container));


$app->group('', function(){
    $this->get('/logout','LoginController:logout')->setName('auth.logout');
    
    $this->get('/dashboard','HomeController:index')->setName('dashboard');
    
    $this->get('/register','RegistrationController:create')->setName('auth.register');
    $this->post('/register','RegistrationController:store')->setName('auth.store');
    
    // users
    $this->get('/users','UserController:index')->setName('user.index');
    $this->post('/users','UserController:search')->setName('user.search');
    $this->get('/users/{id}/edit','UserController:edit')->setName('user.edit');
    $this->put('/users/{id}/edit','UserController:update'); 
    $this->put('/users/{id}/trash','UserController:trashUser')->setName('user.trash');

    // subjects
    $this->get('/subjects','SubjectController:index')->setName('subject.index');
    
    $this->get('/subjects/create','SubjectController:create')->setName('subject.create');
    $this->post('/subjects/create','SubjectController:store');
    $this->post('/subjects','SubjectController:search');

    $this->get('/subject/{id}/edit','SubjectController:edit')->setName('subject.edit');
    $this->put('/subject/{id}/edit','SubjectController:update');
    $this->put('/subject/{id}/trash','SubjectController:trash')->setName('subject.trash');

    // courses

    $this->get('/courses','CourseController:index')->setName('course.index');
    
    $this->get('/courses/create','CourseController:create')->setName('course.create');
    $this->post('/courses/create','CourseController:store');

    $this->get('/course/{id}/edit','CourseController:edit')->setName('course.edit');
    $this->put('/course/{id}/edit','CourseController:update');
    $this->put('/course/{id}/trash','CourseController:trash')->setName('course.trash');
  
    // Students
    $this->get('/students','StudentController:index')->setName('student.index');
    $this->get('/students/search','StudentController:search')->setName('student.search');
    // trash
    $this->put('/students/{id}/trash','StudentController:trash')->setName('student.trash');
    //create
    $this->get('/students/create','StudentController:create')->setName('student.create');
    $this->post('/students/create','StudentController:store');
    // update
    $this->get('/students/{id}/edit','StudentController:edit')->setName('student.edit');
    $this->put('/students/{id}/edit','StudentController:update');

    // single
    $this->get('/students/{id}/view','StudentController:show')->setName('student.show');


    $this->get('/students/secondary','SecondaryController:create')->setName('secondary.create');
    $this->post('/students/secondary','SecondaryController:store');

    $this->get('/students/secondary/{id}/edit','SecondaryController:edit')->setName('secondary.edit');
    $this->put('/students/secondary/{id}/edit','SecondaryController:update')->setName('secondary.update');

    // subjects
    $this->get('/secondary/{id}/mysubjects','MysubjectController:index')->setName('mysubject.index');
    $this->delete('/secondary/{id}/mysubjects','MysubjectController:delete')->setName('mysubject.delete');
    $this->post('/secondary/{id}/mysubjects','MysubjectController:store')->setName('mysubject.post');

  

    // schools
    $this->get('/schools','SchoolController:index')->setName('school.index');
    $this->post('/schools','SchoolController:search');
    
    // create
    $this->get('/schools/create','SchoolController:create')->setName('school.create');
    $this->post('/schools/create','SchoolController:store');

    //update
    $this->get('/schools/{id}/update','SchoolController:edit')->setName('school.edit');
    $this->put('/schools/{id}/update','SchoolController:update'); 


    // Banks
    $this->get('/banks','BankController:index')->setName('bank.index');
    $this->post('/banks','BankController:search');
    // create
    $this->get('/banks/create','BankController:create')->setName('bank.create');
    $this->post('/banks/create','BankController:store');
    // update
    $this->get('/banks/{id}/update','BankController:edit')->setName('bank.edit');
    $this->put('/banks/{id}/update','BankController:update');


    // Hostel
    $this->get('/hostels','HostelController:index')->setName('hostel.index');
    $this->post('/hostels','HostelController:search');

    $this->get('/hostels/create','HostelController:create')->setName('hostel.create');
    $this->post('/hostels/create','HostelController:store');

    // edit
    $this->get('/hostels/{id}/edit','HostelController:edit')->setName('hostel.edit');
    $this->put('/hostels/{id}/edit','HostelController:update');
    
    
    // institutions
    $this->get('/institutions/create','InstitutionController:create')->setName('institution.create');
    $this->post('/institutions/create','InstitutionController:store');

    $this->get('/institutions/{id}/edit','InstitutionController:edit')->setName('institution.edit');
    $this->put('/institutions/{id}/edit','InstitutionController:update');

})->add( new AuthMiddleware($container));


