<?php

namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Student\District;


use Respect\Validation\Validator as v;

class StudentController extends Controller 
{

    /**
     * Return all students
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return view
     */
    public function index($request,$response,$args)
    {
        return $this->view->render($response,'student/personal/index.twig');
    }

    /**
     * Return create view
     *
     * @param [type] $request
     * @param [type] $response
     * @return view
     */
    public function create($request,$response)
    {
        return $this->view->render($response,'student/personal/create.twig');
    }
    
    /**
     * Create a student
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    { 

        /**
         * 
         * Handling validation
         */
        $validator  = $this->Validator->validate($request,[
            'name'              => v::notEmpty(),
            'dob'               => v::notEmpty()->date(),
            'level'             => v::notEmpty(),
            'gender'            => v::notEmpty(), 
            // 'ethnicity'         => v::notEmpty(),
            'entry_grade'       => v::notEmpty(),
            // 'student_phone'     => v::phone(),
            // 'student_email'     => v::email(),
            'parent1_name'      => v::notEmpty(),
            'parent1_phone'     => v::phone(),
            // 'parent2_name'      => v::notEmpty(),
            // 'parent2_phone'     => v::notEmpty(),
            'district'          => v::notEmpty(),
            'subcounty'         => v::notEmpty(),
            // 'village'           => v::notEmpty(),
            'current_state'     => v::notEmpty(),
            // 'dropout_reason'    => v::notEmpty(),
            // 'notes'             => v::notEmpty(),
            'funder'            => v::notEmpty(),
            // 'photo'             => v::notEmpty(),
                   
            ]);

        //    Validation failed
            if($validator->failed()){
                return $response->withRedirect($this->router->pathFor('student.create'));
            }

             
             // upload the file
             $this->files->uploadFile($request,'photo');
            /**
             *posting the new student
             */

            $create = Student::create([
                'name'           => $request->getParam('name'),
                'dob'            => $request->getParam('dob'),
                'level'          => $request->getParam('level'),
                'gender'         => $request->getParam('gender'), 
                'ethnicity'      => $request->getParam('ethnicity'),
                'entry_grade'    => $request->getParam('entry_grade'),
                'student_phone'  => $request->getParam('student_phone'),
                'student_email'  => $request->getParam('student_email'),
                'parent1_name'   => $request->getParam('parent1_name'),
                'parent1_phone'  => $request->getParam('parent1_phone'),
                'parent2_name'   => $request->getParam('parent2_name'),
                'parent2_phone'  => $request->getParam('parent2_phone'),
                'district'       => $request->getParam('district'),
                'subcounty'      => $request->getParam('subcounty'),
                'village'        => $request->getParam('village'),
                'current_state'  => $request->getParam('current_state'),
                'dropout_reason' => $request->getParam('dropout_reason'),
                'notes'          => $request->getParam('notes'),
                'funder'         => $request->getParam('funder'),
                'photo'          => $this->files->filename,
                'created_by'     => $this->auth->user()->name,
                'created_id'     => $this->auth->user()->id,

                ]);

        
        // setting last inserted id into session
         $_SESSION['student_id'] = $create->id;
    
        // flash message
        $this->flash->addMessage('success',' Complete '.ucwords($create->name).' registration' );

        return $response->withRedirect($this->router->pathFor('secondary.create'));
    
    }


}