<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\Student\Subject;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;

class SubjectController extends Controller 
{
    /**
     * Return all subjects
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $subjects = Subject::where('deleted','=','0')
                            ->orderBy('name','ASC')
                            ->paginate(12,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'student/subject/index.twig',[
            'items' => $subjects
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
        return $this->view->render($response,'student/subject/create.twig');

    }

    /**
     * Post subject
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {

        // validation
        $validate = $this->Validator->validate($request,[
            'name' => v::notEmpty()->subjectExist(),
            'category' => v::notEmpty(),
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('subject.create'));
        }

        // create a subject
        Subject::create([
            'name' => $request->getParam('name'),
            'category' => $request->getParam('category')
        ]);

        $this->flash->addMessage('success',ucfirst($request->getParam('name')).' has been added');

        return $response->withRedirect($this->router->pathFor('subject.index'));
    }

    /**
     * Search Subjects
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {
        $name     = $request->getParam('name');
        $category = $request->getParam('category');

        $search = Subject::where('name','like',"%$name%")
                          ->where('category','like',"%$category%")
                          ->where('deleted','=','0')
                          ->limit(12)
                          ->get();

       
        return $this->view->render($response,'student/subject/search.twig',[
            'items' => $search
        ]);
    }

    /**
     * Return subject edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $subject = Subject::find($args['id']);

        return $this->view->render($response,'student/subject/edit.twig',[
            'subject' => $subject
        ]);
    }

    public function update($request,$response,$args)
    {
       
        // validation
         $validate = $this->Validator->validate($request,[
            'name' => v::notEmpty(),
            'category' => v::notEmpty(),
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('subject.edit',[
                'id' =>$args['id']
            ]));
        }

        //update the subject
        $subject = Subject::find($args['id']);

        $subject->update([
            'name'     => $request->getParam('name'),
            'category' => $request->getParam('category')
        ]);

        // flash message
        $this->flash->addMessage('success', ucwords($request->getParam('name')).'  has been updated successfully');

        return $response->withRedirect($this->router->pathFor('subject.index'));
        
    }

    /**
     * Trash the subject
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function trash($request,$response,$args)
    {
        $trash = Subject::find($args['id']);
    
        $trash->update([
            'deleted_by' => $this->auth->user()->name,
            'deleted'    => '1',
            'deleted_at' => date('Y-m-d H:i:s')
        ]);

        // flash message
        $this->flash->addMessage('danger', ucwords($trash->name).'  has been  deleted');
     
       return $response->withRedirect($this->router->pathFor('subject.index'));
             

    }
}