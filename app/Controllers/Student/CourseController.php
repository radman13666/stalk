<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\Student\Course;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;

class CourseController extends Controller 
{
    /**
     * Return all courses
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $courses = Course::where('deleted','=','0')
                             ->paginate(12,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'student/course/index.twig',[
        'items' => $courses
        ]);

    }


    /**
     * Return  create view
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response)
    {
        return $this->view->render($response,'student/course/create.twig');

    }

    /**
     * Post course
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {

        // validation
        $validate = $this->Validator->validate($request,[
            'name'     => v::notEmpty()->courseExist(),
            'category' => v::notEmpty(),
            
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('course.create'));
        }

        // create a course
        Course::create([
            'name'     => $request->getParam('name'),
            'category' => $request->getParam('category'),
            
        ]);

        $this->flash->addMessage('success',ucfirst($request->getParam('name')).' has been added');

        return $response->withRedirect($this->router->pathFor('course.index'));
    }

     /**
     * Return course edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $course = Course::find($args['id']);

        return $this->view->render($response,'student/course/edit.twig',[
            'course' => $course
        ]);
    }

    /**
     * update a course
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function update($request,$response,$args)
    {
       
        // validation
         $validate = $this->Validator->validate($request,[
            'name' => v::notEmpty(),
            'category' => v::notEmpty(),
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('course.edit',[
                'id' =>$args['id']
            ]));
        }

        //update the subject
        $course = Course::find($args['id']);

        $course->update([
            'name'     => $request->getParam('name'),
            'category' => $request->getParam('category')
        ]);

        // flash message
        $this->flash->addMessage('success', ucwords($request->getParam('name')).'  has been updated successfully');

        return $response->withRedirect($this->router->pathFor('course.index'));
        
    }

    /**
     * Trash the course
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function trash($request,$response,$args)
    {
        $trash = Course::find($args['id']);
    
        $trash->update([
            'deleted_by' => $this->auth->user()->name,
            'deleted'    => '1',
            'deleted_at' => date('Y-m-d H:i:s')
        ]);

        // flash message
        $this->flash->addMessage('danger', ucwords($trash->name).'  has been  deleted');
     
       return $response->withRedirect($this->router->pathFor('course.index'));
             

    }


}
