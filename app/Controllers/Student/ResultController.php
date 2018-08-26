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
       



               // text area

        return $this->view->render($response,'student/personal/result_edit.twig',[
            'info'        => $secondary[0],
            'results'     => $results,
            'student'     => $student,
            'allsubjects' => $allsubjects,
            'path'        => $this->files->fileDir(),
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
       $subject   = $request->getParam('subject');
       $mark      =  trim($request->getParam('mark'));
       $grade     = $request->getParam('grade');
       $student_id = trim($request->getParam('student_id'));
       $form       = trim($request->getParam('form'));
       $term       = trim($request->getParam('term'));
       $year       = $request->getParam('year');



        // validation
        $validate = $this->Validator->validate($request,[
            'term'  => v::notEmpty(),
            'form'  => v::notEmpty(),
            'year'  => v::notEmpty(),
            'grade' => v::notEmpty(),
            'mark'  => v::notEmpty()->max(100),
        ]);

        // failed
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('result.create',[
                'id' => $args['id']
            ]));
        }


        // validate repeated results
        $repeated = Result::where('subject_id',$subject)
                            ->where('student_id',$student_id)
                            ->where('academic_year',$year)
                            ->where('s_form',$form)
                            ->where('term',$term)
                            ->exists();

        if($repeated)
        {
           $this->flash->addMessage('danger',$subject.' Result for '.$year.' '.$term.' is already in the Database');
           return $response->withRedirect($this->router->pathFor('result.create',[
            'id' => $args['id']
        ]));
        }

    
       
        $result = Result::create([
            'student_id'   => $student_id,
            'subject_id'   => $subject,
            'mark'         => $mark,
            'grade'        => $grade,
            'academic_year'=> $year,
            'term'         => $request->getParam('term'),
            's_form'       => $form,
            'performance'  => $request->getParam('performance'),
            'created_id'   => $this->auth->user()->id,
            'created_by'   => $this->auth->user()->name,
        ]);     



        // flash messages
        $this->flash->addMessage('success','Results have been successfully added');

        return $response->withRedirect($this->router->pathFor('result.create',[
            'id' =>$args['id']
        ]));
    }

    /**
     * Get All Results
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function allResult($request,$response,$args)
    {

        return $this->view->render($response,'student/personal/allresult.twig');
    }

    /**
     * Get All Results
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function searchResult($request,$response,$args)
    {
        $student_id = trim($request->getParam('student_id'));
        $term = $request->getParam('term');
        $form = $request->getParam('form');
        $year = $request->getParam('year');

       

        // validation
        $validate = $this->Validator->validate($request,[
            'term'  => v::notEmpty(),
            'form'  => v::notEmpty(),
            'year'  => v::notEmpty(),
            'student_id' => v::notEmpty(),
        ]);

        // failed
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('allresult.index',[
                'id' => $args['id']
            ]));
        }


        
        $results = Result::where('term',$term)
                            ->where('s_form',$form)
                            ->where('student_id',$student_id)
                            ->where('academic_year',$year)
                            ->get();

        $average = Result::selectRaw('avg(results.mark) as av')
                    ->where('term',$term)
                    ->where('s_form',$form)
                    ->where('student_id',$student_id)
                    ->where('academic_year',$year)
                    ->first();

            // var_dump($average->av);
            // die();

        $student = Student::where('bursary_id',$student_id)->first();

        $path = $this->files->fileDir();

    
        
        return $this->view->render($response,'student/personal/searchresult.twig',[
            'results'=> $results,
            'average'=> $average->av,
            'student'=> $student,
            'path'  => $path,
            'term'  => $term,
            'year'  => $year,
            'form' => $form
        ]);
    }
   
}