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

use App\Middleware\StudentAuthMiddleware;
use App\Middleware\Roles\SuperadminMiddleware;
use App\Middleware\Roles\ComplainMiddleware;

/*********************************************************************** 
*
*Guest Middleware
*
/*********************************************************************** */
$app->group('',function(){
    $this->get('/','LoginController:index')->setName('auth.login');
    $this->post('/','LoginController:authenticate');

    $this->get('/password_reset','LoginController:resetPassword')->setName('auth.password');
    $this->post('/password_reset','LoginController:password');

    $this->get('/change_password/{code}/{email}','LoginController:confirmReset')->setName('auth.confirm');
    $this->post('/change_password/{code}/{email}','LoginController:saveConfirm')->setName('auth.postconfirm');



    // 
    $this->get('/student/login','StudentAuthController:index')->setName('auth.student');
    $this->post('/student/login','StudentAuthController:authenticate');
  


})->add( new GuestMiddleware($container));



/*********************************************************************** 
*
*Auth Middleware
*
/*********************************************************************** */

$app->group('', function(){
    $this->get('/student/profile','StudentAuthController:profile')->setName('student.profile');
    
    $this->get('/student/profile/logout','StudentAuthController:logout')->setName('student.logout');

    // student complains

    $this->post('/student/complain','ComplainController:store')->setName('student.complain');
    $this->get('/student/{id}/complain','ComplainController:show')->setName('complain.show');
    $this->post('/student/{id}/complain','ComplainController:saveReply');


})->add( new StudentAuthMiddleware($container));

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
    $this->post('/courses','CourseController:search');
 
    // Students
    $this->get('/students','StudentController:index')->setName('student.index');
    $this->post('/students','StudentController:search')->setName('student.search');
   
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

    $this->post('/report/generate','ReportController:studentSummary')->setName('summary.student');
    $this->post('/report/mentorship','ReportController:mentorship')->setName('summary.mentorship');
    $this->post('/report/fullmentorship','ReportController:fullMentorship')->setName('summary.fullmentorship');

    // 
    $this->post('/reports/r','ReportController:report')->setName('report.report');

    // subcounty 
    $this->get('/subcounty','SubcountyController:index')->setName('subcounty.index');
    $this->post('/subcounty','SubcountyController:search');


    // Draft
    $this->get('/students/draft','DraftController:index')->setName('draft.index');
    $this->post('/students/{id}/draft','DraftController:edit')->setName('draft.edit');

    // Results
    $this->get('/student/{id}/results','ResultController:index')->setName('result.index');

    $this->get('/student/results','ResultController:allResult')->setName('allresult.index');
    $this->post('/student/results','ResultController:searchResult');

    // View Payment Details
    $this->get('/student/{id}/payment','HomeController:payment')->setName('amount.payment');

    // Mentors
    $this->get('/mentors','MentorController:index')->setName('mentor.index');
    $this->get('/mentor/{id}/single','MentorController:single')->setName('mentor.single');
    $this->post('/mentors','MentorController:search')->setName('mentor.search');


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
    $this->put('/users/{id}/activate','UserController:activateUser')->setName('user.activate');

    // subject
    $this->put('/subject/{id}/trash','SubjectController:trash')->setName('subject.trash');

    // course
    $this->put('/course/{id}/trash','CourseController:trash')->setName('course.trash');

    // middleware
     $this->put('/students/{id}/trash','StudentController:trash')->setName('student.trash');

    //  upload student email
    // $this->get('/student/upload/secondary','ReportController:uploadSecondary')->setName('upload.secondary');
    // $this->post('/student/upload/secondary','ReportController:postuploadSecondary');


    // upload secondary student

    // $this->get('/student/upload/university','ReportController:uploadSecondary');
    // $this->post('/student/upload/university','ReportController:university')->setName('upload.university');


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


    // 
    $this->get('/mentor/{id}/edit','MentorController:edit')->setName('mentor.edit');
    $this->put('/mentor/{id}/edit','MentorController:update');


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

    $this->get('/students/exist/create','StudentExistController:create')->setName('student.exist');
    $this->post('/students/exist/create','StudentExistController:store');

    // Existing student

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


    // Results
    $this->get('/student/{id}/results/create','ResultController:create')->setName('result.create');
    $this->post('/student/{id}/results/create','ResultController:store');

    // Amount
     
    $this->get('/student/{id}/amount','AmountController:index')->setName('amount.index');
    $this->post('/student/{id}/amount/create','AmountController:store')->setName('amount.create');
    $this->post('/student/{id}/amount','AmountController:export');

    // Mentor
    $this->get('/mentor/create','MentorController:create')->setName('mentor.create');
    $this->post('/mentor/create','MentorController:store');
    

    
    


})->add( new CrMiddleware($container));



/*********************************************************************** 
*
* Superadmin middleware 
*
/*********************************************************************** */

$app->group('', function(){

    // Deleted students
    $this->get('/superadmin/students','StudentTrashController:index')->setName('students.trash');
    $this->post('/superadmin/students','StudentTrashController:search');
    $this->put('/superadmin/{id}/students','StudentTrashController:restore')->setName('students.restore');

    // logs
    $this->get('/superadmin/logs','StudentTrashController:getLog')->setName('log.index');
    $this->post('/superadmin/logs','ReportController:exportLog');

})->add( new SuperadminMiddleware($container));



/*********************************************************************** 
*
*Comlain Manager middleware 
*
/*********************************************************************** */

$app->group('',function(){

    $this->get('/complains','ComplainController:index')->setName('complain.index');
    $this->post('/complains','ComplainController:search')->setName('complain.search');
    $this->get('/complains/{id}/view','ComplainController:single')->setName('complain.single');
    $this->post('/complains/{id}/view','ComplainController:postComplain');
    $this->post('/complains/{id}/closed','ComplainController:closed')->setName('complain.closed');
    $this->post('/complains/{id}/reopen','ComplainController:reopen')->setName('complain.reopen');
    $this->post('/complains/export','ReportController:exportComplain')->setName('complain.export');
    

})->add( new ComplainMiddleware($container));