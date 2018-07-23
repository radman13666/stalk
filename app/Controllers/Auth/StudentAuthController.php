<?php

namespace App\Controllers\Auth;

use Carbon\Carbon as Carbon;
use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Student\Course;
use App\Models\Category\School;
// use App\Models\Category\Tribe;
// use App\Models\Category\Hostel;
// use App\Models\Category\Dropout;
use App\Models\Student\District;
use App\Models\Student\Amount;
// use App\Models\Category\Subcounty;
// use App\Models\Student\Institution;
use App\Models\Student\StudentSubject;

use Respect\Validation\Validator as v;

class StudentAuthController extends Controller
{

    /**
     * Index
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        return $this->view->render($response,'student_login.twig');
    }

    /**
     * Authenticate
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function authenticate($request,$response,$args)
    {
        $name      = trim(ucwords($request->getParam('name')));
        $password       =  trim($request->getParam('password'));


        // $password = Carbon::createFromFormat('Y-mm-dd',$dob);
        // echo $password;
        // die();

        $student = Student::where('name',$name)
                            ->where('dob',$password)
                            ->first();
        
        if($student)
        {
            $_SESSION['student'] =  $student->bursary_id;
            return $response->withRedirect($this->router->pathFor('student.profile'));
        }

        else
        {
           $this->flash->addMessage('danger','Invalid login credentials');

           return $response->withRedirect($this->router->pathFor('auth.student'));
        }
        
    }


    /**
     * Student Details
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function profile($request,$response)
    {

      $student   = Student::where('bursary_id','=',$_SESSION['student'])
                    ->orderBy('id','DESC')
                    ->first();
     $school = School::find($student->school);

    // calculating student age
    $dob = Carbon::parse($student->dob);
    $now  = Carbon::now();


   // $secondary  = Secondary::where('student_id',$student->bursary_id)->get();
    $path = $this->files->fileDir();

       //  Retrieve all amount
    $amount = Amount::where('student_id', '=', $_SESSION['student'])
       ->paginate(4,['*'],'page',$request->getParam('page'));


    return $this->view->render($response,'complains/student/student_profile.twig',[
        'student'     => $student,
        'school'      => $school,
        'path'        => $path,
        'items'       => $amount,
        'subjects'    => $subjects,
        'course'      => $course,
        'age'         => $dob->diffInYears($now)
    ]);

    }


     /**
     * Logout authenticated user
     *
     * @return void
     */
    public function logout($request,$response)
    {
        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.student'));
    }

}
