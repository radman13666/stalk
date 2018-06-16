<?php

namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Category\School;
use App\Models\Student\District;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;
use App\Models\Student\StudentSubject;

use Respect\Validation\Validator as v;

class StudentController extends Controller 
{
    /**
     * File name
     *
     * @var [type]
     */
    protected $photo_name;

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
                            ->paginate(10,['*'],'page',$request->getParam('page'));
                                         
        $path = $this->files->fileDir();
    

        return $this->view->render($response,'student/personal/index.twig',[
            'items' => $students,
            'path'  => $path,
            'district' => $district
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
            'entry_grade'       => v::notEmpty(),
            'parent1_name'      => v::notEmpty(),
            'parent1_phone'     => v::phone(),
            'district'          => v::notEmpty(),
            'subcounty'         => v::notEmpty(),
            'current_state'     => v::notEmpty(),
            'funder'            => v::notEmpty(), 
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
                'student_phone'  => $request->getParam('student_phone'),
                'student_email'  => strtolower($request->getParam('student_email')),
                'parent1_name'   => ucwords($request->getParam('parent1_name')),
                'parent1_phone'  => $request->getParam('parent1_phone'),
                'parent2_name'   => ucwords($request->getParam('parent2_name')),
                'parent2_phone'  => $request->getParam('parent2_phone'),
                'district'       => $district_id,
                'dist_name'      => $district_name,
                'subcounty'      => ucwords($request->getParam('subcounty')),
                'village'        => ucwords($request->getParam('village')),
                'current_state'  => $request->getParam('current_state'),
                'dropout_reason' => nl2br($request->getParam('dropout_reason')),
                'notes'          => nl2br($request->getParam('notes')),
                'funder'         => $request->getParam('funder'),
                'photo'          => $this->files->filename,
                'created_by'     => ucwords($this->auth->user()->name),
                'created_id'     => $this->auth->user()->id,

                ]);

            
        // setting last inserted id into session
         $_SESSION['student_id'] = $create->id;
       
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
        $student = Student::find($args['id']);

        //check student institution category
        if($student->level == 'university' || $student->level == 'tertiary' )
        {
             $institute = Institution::where('student_id',$student->id)->get();
        }
        
        // pull other student information
        if($student->level == 'secondary' )
        {
            $institute = Secondary::where('student_id',$student->id)->get();
        }


        $path =  $this->files->fileDir();

        return $this->view->render($response,'student/personal/partial/personal_edit.twig',[
            'student' => $student,
            'path'    => $path,
            'info'    => $institute[0],
            'category' => $this->category
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
        $student = Student::find($args['id']);

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
            'parent1_phone'     => v::phone(),
            'district'          => v::notEmpty(),
            'subcounty'         => v::notEmpty(),
            'current_state'     => v::notEmpty(),
            'funder'            => v::notEmpty(), 
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
                'student_phone'  => $request->getParam('student_phone'),
                'student_email'  => strtolower($request->getParam('student_email')),
                'parent1_name'   => ucwords($request->getParam('parent1_name')),
                'parent1_phone'  => $request->getParam('parent1_phone'),
                'parent2_name'   => ucwords($request->getParam('parent2_name')),
                'parent2_phone'  => $request->getParam('parent2_phone'),
                'district'       => $district_id,
                'dist_name'      => $district_name,
                'subcounty'      => ucwords($request->getParam('subcounty')),
                'village'        => ucwords($request->getParam('village')),
                'current_state'  => $request->getParam('current_state'),
                'dropout_reason' => nl2br(trim($request->getParam('dropout_reason'))),
                'notes'          => (trim($request->getParam('notes'))),
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
                    $institute = Institution::where('student_id',$student->id)->get();
        
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
    
                $check = Institution::where('student_id',$student->id)->get();
                
                
                            
                                
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
        $student   = Student::find($args['id']);
        $school = School::find($student->school);

        // check student level
       if($student->level=='secondary')
       {
            $institution = Secondary::where('student_id',$student->id)->get();

            $subjects = StudentSubject::leftJoin('subjects','subjects.id','subject_id')
                                        ->where('student_id',$student->id)->get();
       }
       else
       {
            $institution = Institution::where('student_id',$student->id)->get();
       }

        $secondary  = Secondary::where('student_id',$student->id)->get();
        $path = $this->files->fileDir();

        return $this->view->render($response,'student/personal/single.twig',[
            'student'     => $student,
            'school'      => $school,
            'path'        => $path,
            'institution' => $institution[0],
            'subjects'   => $subjects
        ]);
           
    }



}