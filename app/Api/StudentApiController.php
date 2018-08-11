<?php

namespace App\Api;

use Carbon\Carbon as Carbon;
use App\Controllers\Controller;
use App\Models\Student\Student;

use App\Models\Student\Course;
use App\Models\Category\School;
use App\Models\Category\Tribe;
use App\Models\Category\Hostel;
use App\Models\Category\Dropout;
use App\Models\Student\District;
use App\Models\Student\Secondary;
use App\Models\Category\Subcounty;
use App\Models\Student\Institution;
use App\Models\Student\StudentSubject;


class StudentApiController  extends Controller
{
    public $response;

    public function create($request,$response,$args)
    {   
        $name          = trim(ucwords($request->getParam('name')));
        $parent1_phone = trim($request->getParam('parent1_phone'));
        $year_start    =$request->getParam('year_start');

         // upload the file
        //  $this->files->uploadFile($request,'photo');


        if(!empty($name))
        {

            $repeated = Student::where('name',$name)
                                ->where('parent1_phone',$parent1_phone)
                                ->where('year_start',$year)
                                ->count();
            if($repeated == 0){
                      
             $create = Student::create([
                
                'name'           => trim(ucwords($request->getParam('name'))),
                'dob'            => $request->getParam('dob'),
                'level'          => $request->getParam('level'),
                'gender'         => $request->getParam('gender'), 
                'ethnicity'      => $request->getParam('ethnicity'),

                'entry_grade'    => $request->getParam('entry_grade'),
                'student_phone'  => trim($request->getParam('student_phone')),
                'national_id'    => $request->getParam('national_id'),
                'registration_year' => $request->getParam('registration_year'), 
                'year_start'     => $request->getParam('year_start'),
                
                'year_stop'      => $request->getParam('year_stop'),
                'uce_grade'      => $request->getParam('uce_grade'),
                'uace_grade'     => $request->getParam('uace_grade'),
                'student_email'  => strtolower($request->getParam('student_email')),
                'parent1_name'   => ucwords($request->getParam('parent1_name')),
                
                'parent1_phone'  => trim($request->getParam('parent1_phone')),
                'parent2_name'   => ucwords($request->getParam('parent2_name')),
                'parent2_phone'  => trim($request->getParam('parent2_phone')),
                // 'district'       => $district_id,
                'dist_name'      => $request->getParam('dist_name'),
                'subcounty'      => ucwords($request->getParam('subcounty')),
                'village'        => ucwords($request->getParam('village')),

                'current_state'  => $request->getParam('current_state'),
                'dropout_reason' => $request->getParam('dropout_reason'),
                'comments'       => nl2br($request->getParam('comments')),
                'notes'          => nl2br($request->getParam('notes')),
                'funder'         => $request->getParam('funder'),

                // 'photo'          => $this->files->filename,
                // 'photo'          => $this->files->filename,
                // 'created_by'     => ucwords($this->auth->user()->name),
                // 'created_id'     => $this->auth->user()->id,

                ]);


                //  Generating burasry id         
                $year = Carbon::parse($request->getParam('registration_year'))->format('Y');
                $bursary_id = trim($year.$create->id);
                // die();
                $create->update([
                    'bursary_id' => $bursary_id
                ]);
         
                 $_SESSION['student_id'] = $bursary_id;
                 
         

             $this->response= ['message'=>'Success','error'=>false,'code'=>'OK'];
             return $response->withJson($this->response);

            }

  
        }

       

    }

    /**
     * Add additional information for secondary
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function createSecondary($request,$response)
    {


        $student = Student::orderBy('id','DESC')->first();

        $school_name = $request->getParam('school_name');
        
        $school   = School::where('school_name',$school_name)->first();


        $secondary = Secondary::create([
            'school_id'        => $school->id,
            's_form'           => $request->getParam('s_form'),
            'stream'           => $request->getParam('stream'),
            'student_id'       => $student->bursary_id,
            'student_index'    => $request->getParam('student_index'),
            ]);
        
            // update school, bursary id

     
          
        $student->update([
                    'school'     => $school->id,
                    'draft'      =>'0',
                    's_form'     => $secondary->s_form, 
                ]);
    

    // unset($_SESSION['student_id']);

    $this->response= ['message'=>'Success','error'=>false,'session'=>$_SESSION['student_id']];
    return $response->withJson($this->response);
        
    }

    /**
     * Add Institution
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function createInstitution($request,$response)
    {



        $student = Student::orderBy('id','DESC')->first();
        
        // institution
        $school   = School::where('school_name',$request->getParam('institution_name'))->first();

        // hostel
        $hostel = Hostel::where('hostel_name',$request->getParam('hostel_name'))->first();

        // course
        $course = Course::where('name',$request->getParam('course_name'))->first();
        
        // Add institution
        $institution = Institution::create([

            'student_id'          => $student->bursary_id,
            'school_id'           => $school->id,
            'course_id'           => $course->id,
            'qualification'       => $request->getParam('qualification'),
            'student_number'      => $request->getParam('student_number'),
            'registration_number' => $request->getParam('registration_number'),
            'hostel_id'           => $hostel->id,
            's_form'              => $request->getParam('s_form'),
            'student_bank_name'   => $request->getParam('student_bank_name'),
            'student_bank_account'=> $request->getParam('student_bank_account'),
            'student_bank_address'=> $request->getParam('student_bank_address'),
            'other_bank_name'     => $request->getParam('other_bank_name'),
            'other_bank_account'  => $request->getParam('other_bank_account'),
            'other_bank_address'  => $request->getParam('other_bank_address'),
            ]);
        
            // update school, bursary id

        
            
        $student->update([
                    'school'     => $school->id,
                    'draft'      =>'0',
                    's_form'     => $institution->s_form, 
                ]);
    

    // unset($_SESSION['student_id']);

    $this->response= ['message'=>'Success','error'=>false,'session'=>$_SESSION['student_id']];
    return $response->withJson($this->response);

    }
}