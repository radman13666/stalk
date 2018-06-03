<?php
namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Secondary;
use App\Models\Student\StudentSubject;
use Respect\Validation\Validator as v;

class SecondaryController extends Controller 
{

    /**
     * Create secondary students additional information
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function create($request,$response,$args)
    {
        return $this->view->render($response,'student/secondary/create.twig');

    }
    /**
     * Store information
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {
        // check for student session
        if(!isset($_SESSION['student_id']))
        {
            $this->flash->addMessage('danger','Please start a new student registration from here');
            return $response->withRedirect($this->router->pathFor('student.create'));
        }
  
        // Handling validation

        $validate = $this->Validator->validate($request,[
            'school_id'     =>  v::notEmpty(),
            's_form'          =>  v::notEmpty(),
            // 'stream'          =>  v::notEmpty(),
            // 'subjects'        =>  v::notEmpty(),
            // 'student_id'      =>  v::notEmpty(),
            // 'school_code'     =>  v::notEmpty(),
            'year_start'      =>  v::notEmpty(),
            'year_stop'       =>  v::notEmpty(),
            'bank'            =>  v::notEmpty(),
            'bank_address'    =>  v::notEmpty(),
            'bank_account'    =>  v::notEmpty(),
            // 'fav_subject'     =>  v::notEmpty(),
            // 'fav_sport'       =>  v::notEmpty(),
            // 'second_term'     =>  v::notEmpty(),
            // 'third_term'      =>  v::notEmpty(),
        ]);
  
        // validation failed

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('secondary.create'));
        };

    // var_dump ((int) trim($request->getParam('school_id')));
    // die();

        // post info
        Secondary::create([
            'school_id'        => $request->getParam('school_id'),
            's_form'           => $request->getParam('s_form'),
            'stream'           => $request->getParam('stream'),
            'student_id'       => $_SESSION['student_id'],
            'school_code'      => $request->getParam('school_code'),
            'year_start'       => $request->getParam('year_start'),
            'year_stop'        => $request->getParam('year_stop'),
            'bank'             => $request->getParam('bank'),
            'bank_address'     => $request->getParam('bank_address'),
            'bank_account'     => $request->getParam('bank_account'),
            'fav_subject'      => $request->getParam('fav_subject'),
            'fav_sport'        => $request->getParam('fav_sport'),
            'first_term'       => $request->getParam('first_term'),
            'second_term'      => $request->getParam('second_term'),
            'third_term'       => $request->getParam('third_term'),
            'created_by'       => $this->auth->user()->name
            ]);

        /**
         * 
         * Saving student subjects
         * 
         */
        $checkbox = $request->getParam('subjects');
        
        // check if check box is not empty
        if(!empty($checkbox))
        {
        
            foreach ($checkbox as $key => $value) {

                // check if subject already exist
                $subject = StudentSubject::where('student_id',$_SESSION['student_id'])
                                         ->where('subject_id',$value) 
                                         ->count();
                                         
                // subject does not exist
                if($subject < 1)
                {
                    StudentSubject::create([
                        'student_id' => $_SESSION['student_id'],
                        'subject_id' => $value,
                        ]);
                }
            }
          
        }
    
        // unsetting session
        unset($_SESSION['student_id']);
        
        // flash message
        $this->flash->addMessage('success','Student registration has been successfully completed');

        return $response->withRedirect($this->router->pathFor('student.index'));   
    }

}