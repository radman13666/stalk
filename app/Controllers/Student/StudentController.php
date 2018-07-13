<?php

namespace App\Controllers\Student;

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

use Respect\Validation\Validator as v;

class StudentController extends Controller 
{
    /**
     * File name
     *
     * @var string
     */
    protected $photo_name;

    /**
     * Draft
     *
     * @var bool
     */
    protected $draft = false;

    /**
     * Student category
     *
     * @var string
     */
    protected $category = true;

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

        $students = School::Join('students', 'schools.id','=','students.school')
                            ->orderBy('students.name','ASC')
                            ->where('students.deleted','0')
                            ->paginate(10,['*'],'page',$request->getParam('page'));
                                         
        $path = $this->files->fileDir();

     
    

        return $this->view->render($response,'student/personal/index.twig',[
            'items'       => $students,
            'path'        => $path,
            'district'    => $district,
          
            
        ]);
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
        $tribes      = Tribe::orderBy('tribe_name','ASC')->get();
        $subcounties = Subcounty::orderBy('subcounty_name','ASC')->get();
        $dropout     = Dropout::orderBy('reason','ASC')->get();

        return $this->view->render($response,'student/personal/create.twig',[
            'tribes'         => $tribes,
            'subcounties'    => $subcounties,
            'dropouts'        => $dropout
        ]);
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
            'entry_grade'       => v::notEmpty(),
            'parent1_name'      => v::notEmpty(),
            'parent1_phone'     => v::notEmpty(),
            'district'          => v::notEmpty(),
            'subcounty'         => v::notEmpty(),
            'current_state'     => v::notEmpty(),
            'funder'            => v::notEmpty(), 
            'ethnicity'         => v::notEmpty(),
            'year_start'        => v::notEmpty()->date(),
            'year_stop'         => v::notEmpty()->date(), 
            'registration_year' => v::notEmpty()->date(),

    
            // 'student_phone'     => v::phone(),
            // 'student_email'     => v::email(),
            // 'parent2_name'      => v::notEmpty(),
            // 'parent2_phone'     => v::notEmpty(),
            // 'village'           => v::notEmpty(),
            // 'dropout_reason'    => v::notEmpty(),
            // 'notes'             => v::notEmpty(),
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

            $district = $request->getParam('district');
            
            $district_id = preg_replace('/[^0-9]/','', $district);
    
            $district_name  = preg_replace('/[^a-z A-Z]/','',$district);


            $create = Student::create([
                
                'name'           => ucwords($request->getParam('name')),
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
                'district'       => $district_id,
                'dist_name'      => $district_name,
                'subcounty'      => ucwords($request->getParam('subcounty')),
                'village'        => ucwords($request->getParam('village')),
                'current_state'  => $request->getParam('current_state'),
                'dropout_reason' => $request->getParam('dropout_reason'),
                'comments'       => nl2br($request->getParam('comments')),
                'notes'          => nl2br($request->getParam('notes')),
                'funder'         => $request->getParam('funder'),
                'photo'          => $this->files->filename,
                'created_by'     => ucwords($this->auth->user()->name),
                'created_id'     => $this->auth->user()->id,

                ]);

        // Generating burasry id         
        $year = Carbon::parse($request->getParam('registration_year'))->format('Y');
        $bursary_id = trim($year.$create->id);
        
        // pull the lastest student information
       

        $create->update([
            'bursary_id' => $bursary_id
        ]);


        // setting last inserted id into session
         $_SESSION['student_id'] = $create->bursary_id;
       
    /**
     * check for level
     */

        $level = $request->getParam('level');
        
        // flash message
        $this->flash->addMessage('danger',' Please complete '.ucwords($create->name).' registration' );
        
        if( $level == 'secondary')
        {
      
         return $response->withRedirect($this->router->pathFor('secondary.create'));

        }

        elseif( $level == 'university' || $level == 'tertiary')
        {
            return $response->withRedirect($this->router->pathFor('institution.create'));

        }

        else 
        {
            return $response->withRedirect($this->router->pathFor('student.index'));
        }
      
    
    }

    /**
     * Return student edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {

        $tribes      = Tribe::orderBy('tribe_name','ASC')->get();
        $subcounties = Subcounty::orderBy('subcounty_name','ASC')->get();
        $dropout     = Dropout::orderBy('reason','ASC')->get();

        $student = Student::where('bursary_id', '=',$args['id'])->first();

        //is student in higher institute of learning 
        if($student->level == 'university' || $student->level == 'tertiary' )
        {
             $institute = Institution::where('student_id',$student->bursary_id)->get();
        }
        
        // is student at secondary level
        if($student->level == 'secondary' )
        {
            $institute = Secondary::where('student_id',$student->bursary_id)->get();
        }


        $path =  $this->files->fileDir();

        return $this->view->render($response,'student/personal/partial/personal_edit.twig',[
            'student' => $student,
            'path'    => $path,
            'info'    => $institute[0],
            'category' => $this->category,
            'tribes'    => $tribes,
            'subcounties' => $subcounties,
            'dropouts'    => $dropout
        ]);
    }

    /**
     * Update student
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function update($request,$response,$args)
    {
        // 
        $student = Student::where('bursary_id','=',$args['id'])->first();

        // 
      $old_level = $student->level;
       
         /**
         * 
         * Handling validation
         */
        $validator  = $this->Validator->validate($request,[
            'name'              => v::notEmpty(),
            'dob'               => v::notEmpty()->date(),
            'level'             => v::notEmpty(),
            'gender'            => v::notEmpty(),
            'entry_grade'       => v::notEmpty(),
            'parent1_name'      => v::notEmpty(),
            'parent1_phone'     => v::notEmpty(),
            'district'          => v::notEmpty(),
            'subcounty'         => v::notEmpty(),
            'current_state'     => v::notEmpty(),
            'funder'            => v::notEmpty(), 
            'ethnicity'         => v::notEmpty(),
            'year_start'        => v::notEmpty()->date(),
            'year_stop'         => v::notEmpty()->date(), 
            'registration_year' => v::notEmpty()->date(),

            // 'ethnicity'         => v::notEmpty(),
            // 'student_phone'     => v::phone(),
            // 'student_email'     => v::email(),
            // 'parent2_name'      => v::notEmpty(),
            // 'parent2_phone'     => v::notEmpty(),
            // 'village'           => v::notEmpty(),
            // 'dropout_reason'    => v::notEmpty(),
            // 'notes'             => v::notEmpty(),
            // 'photo'             => v::notEmpty(),
                   
            ]);

        //    Validation failed
            if($validator->failed()){
                return $response->withRedirect($this->router->pathFor('student.create'));
            }

            //  handling file upload
            if(isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))

            {
             // old photo name
               $old_photo = $this->files->rootPath().$student->photo;
            
            //  remove the old photo
             $old_photo ? unlink($old_photo): ' ';

            //    upload the new photo
               $new_photo  = $this->files->uploadFile($request,'photo');

            //    new photo name
                $this->photo_name = $this->files->filename;
            }
            else{
            //old photo name

                $this->photo_name = $student->photo;
            }

            // pulling district
            $district = $request->getParam('district');
            
            $district_id = preg_replace('/[^0-9]/','', $district);
    
            $district_name  = preg_replace('/[^a-z A-Z]/','',$district);


            // update student
            $update = $student->update([
                'name'           => ucwords($request->getParam('name')),
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
                'district'       => $district_id,
                'dist_name'      => $district_name,
                'subcounty'      => ucwords($request->getParam('subcounty')),
                'village'        => ucwords($request->getParam('village')),
                'current_state'  => $request->getParam('current_state'),
                'dropout_reason' => $request->getParam('dropout_reason'),
                'comments'       => nl2br($request->getParam('comments')),
                'notes'          => nl2br($request->getParam('notes')),
                'funder'         => $request->getParam('funder'),
                'photo'          => $this->photo_name,
                
                // 'created_by'     => $this->auth->user()->name,
                // 'created_id'     => $this->auth->user()->id,

                ]);

            

          /**
          * Fixing school information update bug
          *check student institution category
          * 
          */
          $level_request = $request->getParam('level');

          if( $level_request != $old_level )
          {

  
    
            if( $level_request  == 'university' ||  $level_request  == 'tertiary' )
            {

               
                
                if($old_level == 'university' || $old_level == 'tertiary')
                {
                   
                }
                else
                {
                    $institute = Institution::where('student_id',$student->bursary_id)->get();
        
                    $check = Secondary::where('student_id',$args['id'])->get();
        
                    //  query all student subjects
                    $subjects = StudentSubject::where('student_id',$args['id'])->get();
                    
                    //  check if student is in  a university or tertiary institution
                    if( empty($institute) || !empty($check) )
                    { 
                        
                
                        $this->category = false;
                        
                       
                        // delete the data in secondary level
                            $delete = $this->db->table('secondary')->where('id',$check[0]->id)->delete();
                       
        
                        // delete all subjects belonging to the student
                        if(!empty($subjects))
                        {
                            $delSUbject = $this->db->table('student_subjects')->where('student_id',$args['id'])->delete();                    
                        }
                        
                        $_SESSION['student_id']  = $args['id'];
                        $this->flash->addMessage('warning','Please update the information below');
                        return $response->withRedirect($this->router->pathFor('institution.create'));  
                        
                    }
                }
                
               
                
                
            }
            
            /**
             * secondary student information
             * 
             */ 
            if( $level_request  == 'secondary' )
            {

                // var_dump('secondary');
                // die();
    
                
                $institution = Secondary::where('student_id',$args['id'])->get();
    
                $check = Institution::where('student_id',$student->bursary_id)->get();
                
                
                            
                                
            //  check if student is in  a university or tertiary institution
                if(empty($institute) || !empty($check) )
                { 
                
                    $this->category = false;
                    
                  
                        // delete the data in secondary level
                     $delete = $this->db->table('institutions')->where('id',$check[0]->id)->delete();
                  
        
                    $_SESSION['student_id']  = $args['id'];

                    // flash
                    $this->flash->addMessage('warning','Please update  the information below');
                    
                    return $response->withRedirect($this->router->pathFor('secondary.create'));  
                        
                }
            }
  
      }

        //   add a flash message
        $this->flash->addMessage('success',ucwords($request->getParam('name')).' information has been updated successfully');
        
        return $response->withRedirect($this->router->pathFor('student.edit',[
            'id' => $args['id'],
            
        ]));


    }

    /**
     * Search method
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {
        // getting all the fields
        $name      = $request->getParam('name');
        $district  = $request->getParam('district');
        $school    = $request->getParam('school');
        $gender    = $request->getParam('gender');
        $status    = $request->getParam('status');
        $form      = $request->getParam('form');

        $students = School::Join('students', 'schools.id','=','students.school')
                           ->where('students.name','like',"%$name%")
                           ->where('students.dist_name','like',"%$district%")
                           ->where('students.school','like',"%$school%")
                           ->where('students.gender','like',"%$gender%")
                           ->where('students.current_state','like',"%$status%")
                           ->where('students.s_form','like',"%$form%")
                           ->where('deleted','0')
                           ->orderBy('students.name','ASC')
                           ->get();
                                        
        $path = $this->files->fileDir();


        return $this->view->render($response,'student/personal/search.twig',[
        'items' => $students,
        'path'  => $path,
        'district' => $district
        ]);


    }
    /**
     * This method shows students details on a single page
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function show($request,$response,$args)
    {
        $student   = Student::where('bursary_id','=',$args['id'])->first();
        $school = School::find($student->school);

        // calculating student age
        $dob = Carbon::parse($student->dob);
        $now  = Carbon::now();

      
        // check student level
       if($student->level=='secondary')
       {
            $institution = Secondary::where('student_id',$student->bursary_id)->get();

            $subjects = StudentSubject::leftJoin('subjects','subjects.id','subject_id')
                                        ->where('student_id',$student->bursary_id)->get();
            
            
       }
       else
       {
             $institution = Institution::where('student_id',$student->bursary_id)->get();
             $course      = Course::find($institution[0]->course_id);
             $hostel      = Hostel::find($institution[0]->hostel_id);
       }

        // $secondary  = Secondary::where('student_id',$student->bursary_id)->get();
        $path = $this->files->fileDir();

        return $this->view->render($response,'student/personal/single.twig',[
            'student'     => $student,
            'school'      => $school,
            'path'        => $path,
            'institution' => $institution[0],
            'subjects'    => $subjects,
            'course'      => $course,
            'hostel'      => $hostel,
            'age'         => $dob->diffInYears($now)
        ]);
           
    }


    /**
     * Trash 
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function trash($request,$response,$args)
    {
        $trash = Student::find($args['id']);
        
            $trash->update([
                'deleted_by' => $this->auth->user()->name,
                'deleted'    => '1',
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
    
            // flash message
        $this->flash->addMessage('danger', ucwords($trash->name).'  has been  deleted');
         
        return $response->withRedirect($this->router->pathFor('student.index'));

    }


}