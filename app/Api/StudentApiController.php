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
        $name = $request->getParam('name');

         // upload the file
        //  $this->files->uploadFile($request,'photo');

        
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


                 // Generating burasry id         
                $year = Carbon::parse($request->getParam('registration_year'))->format('Y');
                $bursary_id = trim($year.$create->id);
                
                // pull the lastest student information
            
                // if(!empty($request->getParam('bursary_id')))
                // {
                //     $bursary_id = $request->getParam('bursary_id');
                // }
                // else
                // {
                //     $bursary_id = $bursary_id;
                // }

                // $this->response= ['message'=>'Success','error'=>false,'code'=>'OK'];
                // return $response->withJson($this->response);

                // $_SESSION['student_id'] = $bursary_id;

                $school_name = $request->getParam('school_name');
                
                $school   = School::where('school_name',$school_name)->first();
                
          

                $create->update([
                    'bursary_id' => $bursary_id,
                    'school'     => $school->id,
                    'draft'      =>'0',
                    's_form'     => $request->getParam('form')  
                ]);
                

              

                


                  $secondary = Secondary::create([
                    'school_id'        => $school->id,
                    's_form'           => $request->getParam('form'),
                    'stream'           => $request->getParam('stream'),
                    'student_id'       => $bursary_id,
                    'student_index'    => $request->getParam('student_index'),
                    ]);



            //  unset($_SESSION['student_id']);

             $this->response= ['message'=>'Success','error'=>false,'code'=>'OK','school'=>$school->id];
             return $response->withJson($this->response);

       

    }

    public function createSecondary($request,$response)
    {
        
    }
}