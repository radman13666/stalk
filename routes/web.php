<?php

/**
 * 
 * This contains all the web routes
 * 
 */

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

use App\Middleware\Roles\CrMiddleware;
use App\Middleware\Roles\CruMiddleware;
use App\Middleware\Roles\CrudMiddleware;
use App\Middleware\Roles\SuperadminMiddleware;

/*********************************************************************** 
*
*Guest Middleware
*
/*********************************************************************** */
$app->group('',function(){
    $this->get('/','LoginController:index')->setName('auth.login');
    $this->post('/','LoginController:authenticate');
})->add( new GuestMiddleware($container));



/*********************************************************************** 
*
*Auth Middleware
*
/*********************************************************************** */
$app->group('', function(){

    $this->get('/logout','LoginController:logout')->setName('auth.logout');
    $this->get('/dashboard','HomeController:index')->setName('dashboard');

    $this->get('/changepassword', 'ChangePasswordController:show')->setName('changepassword');
    $this->put('/changepassword', 'ChangePasswordController:update');
    
    
    // subjects
    $this->get('/subjects','SubjectController:index')->setName('subject.index');
    $this->post('/subjects','SubjectController:search');

    // courses
    $this->get('/courses','CourseController:index')->setName('course.index');
 
    // Students
    $this->get('/students','StudentController:index')->setName('student.index');
    $this->get('/students/search','StudentController:search')->setName('student.search');
   
    // single
    $this->get('/students/{id}/view','StudentController:show')->setName('student.show');

    // subjects
    $this->get('/secondary/{id}/mysubjects','MysubjectController:index')->setName('mysubject.index');
  
    // schools
    $this->get('/schools','SchoolController:index')->setName('school.index');
    $this->post('/schools','SchoolController:search');
    $this->get('/schools/{id}/show','SchoolController:show')->setName('school.show');

    // Banks
    $this->get('/banks','BankController:index')->setName('bank.index');
    $this->post('/banks','BankController:search');

    // Accomodation
    $this->get('/hostels','HostelController:index')->setName('hostel.index');
    $this->post('/hostels','HostelController:search');

    // Generating reports
    $this->get('/reports','ReportController:index')->setName('report.index');
    $this->post('/reports','ReportController:generate');

    // subcounty controller
    $this->get('/subcounty','SubcountyController:index')->setName('subcounty.index');
    $this->post('/subcounty','SubcountyController:search');


})->add( new AuthMiddleware($container));


/*********************************************************************** 
*
*Crud (Cread, Read, Update and Delete) all permission middleware 
*
/*********************************************************************** */

$app->group('', function(){

    // auth
    $this->get('/register','RegistrationController:create')->setName('auth.register');
    $this->post('/register','RegistrationController:store')->setName('auth.store');

    // user
    $this->get('/users','UserController:index')->setName('user.index');
    $this->post('/users','UserController:search')->setName('user.search');
    $this->get('/users/{id}/edit','UserController:edit')->setName('user.edit');
    $this->put('/users/{id}/edit','UserController:update'); 
    $this->put('/users/{id}/trash','UserController:trashUser')->setName('user.trash');

    // subject
    $this->put('/subject/{id}/trash','SubjectController:trash')->setName('subject.trash');

    // course
    $this->put('/course/{id}/trash','CourseController:trash')->setName('course.trash');

    // middleware
     $this->put('/students/{id}/trash','StudentController:trash')->setName('student.trash');

    

})->add( new CrudMiddleware($container));


/*********************************************************************** 
*
*Cru (Cread, Read and  Update ) permission middleware 
*
/*********************************************************************** */

$app->group('', function(){
    
    // subjects
    $this->get('/subject/{id}/edit','SubjectController:edit')->setName('subject.edit');
    $this->put('/subject/{id}/edit','SubjectController:update');

    // courses
    $this->get('/course/{id}/edit','CourseController:edit')->setName('course.edit');
    $this->put('/course/{id}/edit','CourseController:update');

    // students
    $this->get('/students/{id}/edit','StudentController:edit')->setName('student.edit');
    $this->put('/students/{id}/edit','StudentController:update');

    // secondary student information
    $this->get('/students/secondary/{id}/edit','SecondaryController:edit')->setName('secondary.edit');
    $this->put('/students/secondary/{id}/edit','SecondaryController:update')->setName('secondary.update');

    // subjects
    $this->delete('/secondary/{id}/mysubjects','MysubjectController:delete')->setName('mysubject.delete');
    $this->post('/secondary/{id}/mysubjects','MysubjectController:store')->setName('mysubject.post');

    // schools
    $this->get('/schools/{id}/update','SchoolController:edit')->setName('school.edit');
    $this->put('/schools/{id}/update','SchoolController:update');

    // bank    
    $this->get('/banks/{id}/update','BankController:edit')->setName('bank.edit');
    $this->put('/banks/{id}/update','BankController:update');

    // accomodation
    $this->get('/hostels/{id}/edit','HostelController:edit')->setName('hostel.edit');
    $this->put('/hostels/{id}/edit','HostelController:update');

    // Institution
    $this->get('/institutions/{id}/edit','InstitutionController:edit')->setName('institution.edit');
    $this->put('/institutions/{id}/edit','InstitutionController:update');

    // subcounty
    $this->get('/subcounty/{id}/edit','SubcountyController:edit')->setName('subcounty.edit');
    $this->put('/subcounty/{id}/edit','SubcountyController:update');

})->add( new CruMiddleware($container));

/*********************************************************************** 
*
*Cr (Cread and Read  ) permission middleware 
*
/*********************************************************************** */

$app->group('', function(){
    
    // Subject
    $this->get('/subjects/create','SubjectController:create')->setName('subject.create');
    $this->post('/subjects/create','SubjectController:store'); 

    // course   
    $this->get('/courses/create','CourseController:create')->setName('course.create');
    $this->post('/courses/create','CourseController:store');

    // students
    $this->get('/students/create','StudentController:create')->setName('student.create');
    $this->post('/students/create','StudentController:store');

    // secondary
    $this->get('/students/secondary','SecondaryController:create')->setName('secondary.create');
    $this->post('/students/secondary','SecondaryController:store');

    // school
    $this->get('/schools/create','SchoolController:create')->setName('school.create');
    $this->post('/schools/create','SchoolController:store');

    // bank
    $this->get('/banks/create','BankController:create')->setName('bank.create');
    $this->post('/banks/create','BankController:store');

    // accomodation
    $this->get('/hostels/create','HostelController:create')->setName('hostel.create');
    $this->post('/hostels/create','HostelController:store');
    
    // institutions
    $this->get('/institutions/create','InstitutionController:create')->setName('institution.create');
    $this->post('/institutions/create','InstitutionController:store');
    // subcounty
    $this->get('/subcounty/create','SubcountyController:create')->setName('subcounty.create');
    $this->post('/subcounty/create','SubcountyController:store');


})->add( new CrMiddleware($container));



/*********************************************************************** 
*
* Superadmin middleware 
*
/*********************************************************************** */

$app->group('', function(){

    // Delete
    $this->get('superadmin/students','StudentTrashController:index')->setName('students.trash');

})->add( new SuperadminMiddleware($container));