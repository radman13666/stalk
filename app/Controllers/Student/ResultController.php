<?php
namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Subject;
use App\Models\Student\Result;
use App\Models\Student\Student;
use App\Models\Category\School;
use App\Models\Student\Secondary;
use App\Models\Student\StudentSubject;
use Respect\Validation\Validator as v;

class ResultController extends Controller
{

    /**
     * Retrieve all results
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
               $student = Student::where('bursary_id','=',$args['id'])->first();

                //get school
                $secondary = Secondary::where('student_id',$student->bursary_id)->get();
         
                $allsubjects = Subject::all();

                  //  Retrieve all results
                $results = Result::where('student_id', '=', $student->bursary_id)->latest()->get();
        
                return $this->view->render($response,'student/personal/partial/base_result.twig',[
                    'info'        => $secondary[0],
                    'results'     => $results,
                    'student'     => $student,
                    'allsubjects' => $allsubjects,
                    'path'        => $this->files->fileDir()
                ]);
    }

    /**
     * return create view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function create($request,$response,$args)
    { 

        $student = Student::where('bursary_id','=',$args['id'])->first();
        
        //get school
        $secondary = Secondary::where('student_id',$student->bursary_id)->get();

    
        $allsubjects = StudentSubject::leftJoin('subjects','subject_id','=','subjects.id')
                                ->where('student_id','=',$args['id'])->get();

            //  Retrieve all results
        $results = Result::where('student_id', '=', $student->bursary_id)->latest()->get();

        return $this->view->render($response,'student/personal/result_edit.twig',[
            'info'        => $secondary[0],
            'results'     => $results,
            'student'     => $student,
            'allsubjects' => $allsubjects,
            'path'        => $this->files->fileDir()
        ]);

    }

    /**
     * Store results
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {
      // looping through all the subjects
       $subjects = $request->getParam('subject_id');
       $marks    =  $request->getParam('mark');
       $grades    =  $request->getParam('grade');

      

    //    var_dump($subjects);
    //    die();
    $arrays = [$subjects,$marks,$grades];
    explode('|',$arrays);

      foreach($subjects as $subject)
      {
          
            // create a new
            $result = Result::create([
                'student_id'   => trim($request->getParam('student_id')),
                'subject_id'   => $value,
                'mark'        => $request->getParam('mark'),
                'academic_year'=> $request->getParam('year'),
                'grade'        => $request->getParam('grade'),
                'term'         => $request->getParam('term'),
                's_form'       => trim($request->getParam('form')),
                'performance'  => $request->getParam('performance'),
                'created_id'   => $this->auth->user()->id,
                'created_by'   => $this->auth->user()->name,
            ]);
                
        
      }
  


        // validation
        $validate = $this->Validator->validate($request,[
            'term'  => v::notEmpty(),
            'form'  => v::notEmpty(),
            'year'  => v::notEmpty()
        ]);

        // failed
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('result.create',[
                'id' => $args['id']
            ]));
        }

   
   
     
           
       

        // flash messages
        $this->flash->addMessage('success','Results have been successfully added');

        return $response->withRedirect($this->router->pathFor('result.index',[
            'id' =>$args['id']
        ]));

    }
   
}