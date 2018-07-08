<?php
namespace App\Controllers\Category;

use App\Controllers\Controller;
use App\Models\Student\Subject;
use App\Models\Student\Student;
use App\Models\Category\School;
use App\Models\Student\Secondary;
use App\Models\Student\StudentSubject;

class MysubjectController extends  Controller 
{

    /**
     * Return subject view
     *
     * @param [type] $resquest
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($resquest,$response,$args)
    {
        $student = Student::where('bursary_id',$args['id'])->first();

        //get student
        $secondary = Secondary::where('student_id',$student->id)->get();
        
        // get all subjects
        $subjects = Subject::leftJoin('student_subjects','subjects.id','=','student_subjects.subject_id')
                                ->where('student_id','=',$args['id'])->get();

         $allsubjects = Subject::all();

       

        return $this->view->render($response,'student/personal/partial/subject_update.twig',[
            'info'        => $secondary[0],
            'subjects'    => $subjects,
            'student'     => $student,
            'allsubjects' => $allsubjects,
            'path'        => $this->files->fileDir()
        ]);

    }

    /**
     * Delete subject
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function delete($request,$response,$args)
    {
        
        $delete = StudentSubject::find($args['id']);

        // get student id
        $student =  $delete->student_id;
      
        $delete->delete();

        $this->flash->addMessage('danger','Subject has been deleted');
        return $response->withRedirect($this->router->pathFor('mysubject.index',[
            'id' => $student
        ]));

    }

    /**
     * Add a new subject to a student
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {
        $subject_id = (int)$args['id'];
        $student_id = (int) $request->getParam('student_id');


        //student
        $student = Student::where('bursary_id', '=',$student_id)->first();

        // handle validation
        $validate = StudentSubject::where('student_id',$student_id)
                                    ->where('subject_id',$subject_id)
                                    ->count();
        // 
        if($validate > 0)
        {
            $this->flash->addMessage('danger',ucwords($student->name).'  already have this subject');

            return $response->withRedirect($this->router->pathFor('mysubject.index',[
                'id' => $student_id
            ]));
        }

        // post data
        StudentSubject::create([
            'student_id' => $student_id,
            'subject_id' => $subject_id
        ]);


        $this->flash->addMessage('success','You have successfully added this subject to '.ucwords($student->name));

        return $response->withRedirect($this->router->pathFor('mysubject.index',[
            'id' => $student_id
        ]));
    }
}