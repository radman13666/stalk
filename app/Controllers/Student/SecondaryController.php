<?php
namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Category\School;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;
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
          // check for student session
          if(!isset($_SESSION['student_id']))
          {
              $this->flash->addMessage('danger','Please start a new student registration from here');
              return $response->withRedirect($this->router->pathFor('student.create'));
          }
    
        return $this->view->render($response,'student/secondary/create.twig');

    }
    /**
     * Store  seondary students information
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {

        // Handling validation

        $validate = $this->Validator->validate($request,[
            'school_id'     =>  v::notEmpty(),
            's_form'        =>  v::notEmpty(),
            // 'fav_subject'=>  v::notEmpty(),
            // 'fav_sport'  =>  v::notEmpty(),
      
        ]);
  
        // validation failed

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('secondary.create'));
        };

  
       //    check if the student id is already in the databse
     
       $isAvailable = Secondary::where('student_id','=',$_SESSION['student_id'])->count();

      if($isAvailable < 1){
        // post info
       $secondary = Secondary::create([
            'school_id'        => $request->getParam('school_id'),
            's_form'           => $request->getParam('s_form'),
            'stream'           => $request->getParam('stream'),
            'student_id'       => $_SESSION['student_id'],
            'student_number'   => $request->getParam('student_number'),
            'student_index'    => $request->getParam('student_index'),
            'fav_subject'      => $request->getParam('fav_subject'),
            'fav_sport'        => $request->getParam('fav_sport'),
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

    }

    else
    {
        $Available = Secondary::where('student_id','=',$_SESSION['student_id'])->get();
        $secondary = $Available[0];
    }

        /**
         * Update student school and level
         * 
         */

           
        $student =  Student::where('bursary_id','=',$secondary->student_id)->first();
        
        $update  = $student->update([
                'school'   => $secondary->school_id,
                's_form'   => $secondary->s_form,
                'draft'    => '0'
            ]);   


        // unsetting session
        unset($_SESSION['student_id']);
        
        // flash message
        $this->flash->addMessage('success','Student registration has been successfully completed');

        return $response->withRedirect($this->router->pathFor('student.index'));   
    }

    /**
     * Return edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function  edit($request,$response,$args)
    {
        
        $secondary = Secondary::find($args['id']);

        //get student
        $student = Student::find($secondary->student_id);
       
        // get school name
        $school = School::where('id','=',$secondary->school_id)->get();

        return $this->view->render($response,'student/personal/partial/secondary_edit.twig',[
            'info'    => $secondary,
            'school'  => $school[0],
            'student' => $student,
            'path'    => $this->files->fileDir()
        ]);

    }
    
    /**
     * Update
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
     public function update($request,$response,$args)
     {
       
       //   pull old data
        $old_data = Secondary::find($args['id']);

        //  pull student information
        $student = Student::find($old_data->student_id);

        // check if the student exist in instution table
        $institution = Institution::find($student->id);

        if($institution)
        {
            $del =  $institution->delete();
        }
       

         $update = $old_data->update([
            'school_id'        => $request->getParam('school_id'),
            's_form'           => $request->getParam('s_form'),
            'stream'           => $request->getParam('stream'),
            'student_number'   => $request->getParam('student_number'),
            'student_index'    => $request->getParam('student_index'),
            'fav_subject'      => $request->getParam('fav_subject'),
            'fav_sport'        => $request->getParam('fav_sport'),
         ]);
        
        //  new data
        $new_data = Secondary::find($args['id']);
       
         $this->students->schoolForm($new_data->student_id,$new_data);
           //   add a flash message
        $this->flash->addMessage('success', ucwords($student->name).'  Information has been updated successfully');
        
        return $response->withRedirect($this->router->pathFor('secondary.edit',[
            'id' => $new_data->id
        ]));
        

     }
 

} 