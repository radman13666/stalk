<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\Student\Complain;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;

class ComplainController extends Controller 
{
  
    /**
     * Store students  complains
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {

          // validation
        $validate = $this->Validator->validate($request,[
            'title'     => v::notEmpty(),
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('student.profile'));
        }

        // create a course
        Complain::create([
            'title'        => $request->getParam('title'),
            'body'         => $request->getParam('body'),
            'student_id'   => $_SESSION['student'],
            'student_name' => $this->auth->studentProfile()->name,
            
        ]);

        $this->flash->addMessage('success',ucfirst($request->getParam('title')).' has been submitted');

        return $response->withRedirect($this->router->pathFor('student.profile'));

    }


}
