<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\Category\Hostel;
use App\Models\Student\Student;
use App\Models\Student\Course;
use App\Models\Category\School;
use App\Models\Student\Institution;
use App\Models\Category\Qualification;
use Respect\Validation\Validator as v;
class InstitutionController extends Controller
{
   

    /**
     * Return institution create view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function create($request,$response,$args)
    {
        // check for student session
        if(!isset($_SESSION['student_id']))
        {
            $this->flash->addMessage('danger','Please start a new student registration from here');
            return $response->withRedirect($this->router->pathFor('student.create'));
        }
        

       $institutions = $this->helper->allInstitutions();
       $qualification = Qualification::all();
    
        return $this->view->render($response,'student/institution/create.twig',[
            'institutions'   => $institutions,
            'qualifications' => $qualification
        ]);
    }

    /**
     * Store additional info
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {

        // validation
        $validator = $this->Validator->validate($request,[
            'institution_name'          => v::notEmpty(),
            'course_id'                 => v::notEmpty(),
            'qualification'             => v::notEmpty(),
            // 'student_number'            => v::notEmpty(),
            'registration_number'       => v::notEmpty(),
            'year_start'                => v::notEmpty(),
            'year_stop'                 => v::notEmpty(),
            'hostel_id'                 => v::notEmpty(),
            's_form'                   => v::notEmpty(),
            'student_bank_name'         => v::notEmpty(),
            'student_bank_details'      => v::notEmpty(),
            'institution_bank_name'     => v::notEmpty(),
            'institution_bank_details'  => v::notEmpty(),
            // 'other_bank_name'           => v::notEmpty(),
            // 'other_bank_details'        => v::notEmpty(),
        ]);

        // validation failed
        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('institution.create'));
        }

        // Save data

        $institution = Institution::create([
                        'school_id'                => ucwords($request->getParam('institution_name')),
                        'course_id'                => $request->getParam('course_id'),
                        'student_id'               => $_SESSION['student_id'],
                        'qualification'            => $request->getParam('qualification'),
                        'student_number'           => $request->getParam('student_number'),
                        'registration_number'      => $request->getParam('registration_number'),
                        'year_start'               => $request->getParam('year_start'),
                        'year_stop'                => $request->getParam('year_stop'),
                        'hostel_id'                => $request->getParam('hostel_id'),
                        's_form'                   => $request->getParam('s_form'),
                        'student_bank_name'        => $request->getParam('student_bank_name'),
                        'student_bank_details'     => $request->getParam('student_bank_details'),
                        'institution_bank_name'    => $request->getParam('institution_bank_name'),
                        'institution_bank_details' => $request->getParam('institution_bank_details'),
                        'other_bank_name'          => $request->getParam('other_bank_name'),
                        'other_bank_details'       => $request->getParam('other_bank_details'),
                        'created_by'               => ucwords($this->auth->user()->name)
                    ]);
    
        /**
         * Update student school and level
         * 
         */

        $this->students->schoolForm($institution->student_id,$institution);
        
            
        
        // unsetting session
        unset($_SESSION['student_id']);
        
        // flash message
        $this->flash->addMessage('success','Student registration has been successfully completed');

        return $response->withRedirect($this->router->pathFor('student.index'));  

    }

    /**
     * Return institution edit
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $institution = Institution::find($args['id']);

        
        //get student
        $student = Student::find($institution->student_id);
               
        // get school name
        $school = School::where('id','=',$institution->school_id)->get();

        // pull category
        $institutions = $this->helper->allInstitutions();
        $qualification = Qualification::all();

        // hostel
        $hostel = Hostel::find($institution->hostel_id);
        // course
        $course  = Course::find($institution->course_id);



        return $this->view->render($response,'student/personal/partial/institution_edit.twig',[
            'info'               => $institution,
            'school'             => $school[0],
            'student'            => $student,
            'path'               => $this->files->fileDir(),
            'institutions'       => $institutions,
            'qualifications'     => $qualification,
            'hostel'             => $hostel,
            'course'             => $course,
        ]);

    }

}
