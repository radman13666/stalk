<?php

namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Category\School;
use App\Models\Student\District;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;

use Respect\Validation\Validator as v;

class StudentController extends Controller 
{

    protected $photo_name;

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
                            ->get();
                                         
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
                'dropout_reason' => $request->getParam('dropout_reason'),
                'notes'          => $request->getParam('notes'),
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

        // pull other student information
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
            'info'    => $institute[0]
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
        $student = Student::find($args['id']);
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
                'dropout_reason' => $request->getParam('dropout_reason'),
                'notes'          => $request->getParam('notes'),
                'funder'         => $request->getParam('funder'),
                'photo'          => $this->photo_name,
                // 'created_by'     => $this->auth->user()->name,
                // 'created_id'     => $this->auth->user()->id,

                ]);

        //   add a flash message
        $this->flash->addMessage('success',ucwords($request->getParam('name')).' information has been updated successfully');

        return $response->withRedirect($this->router->pathFor('student.edit',[
            'id' => $args['id']
        ]));

    }



}