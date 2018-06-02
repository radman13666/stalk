<?php
namespace App\Controllers\Category;

use App\Controllers\Controller;
use App\Models\Category\School;
use App\Models\Student\District;
use Respect\Validation\Validator as v;

class SchoolController extends Controller 
{
    
    /**
     * Return all Schools
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $schools = District::Join('schools','schools.district_id','=','districts.id')
                           ->orderBy('school_name','ASC')
                           ->paginate(12,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'category/school/index.twig',[
            'items' => $schools
        ]);
    }

    /**
     * Return create view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return view
     */
    public function create($request,$response,$args)
    {
        return $this->view->render($response,'category/school/create.twig');
    }

    /**
     * Save school or institution
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {
        // validation
        $validate = $this->Validator->validate($request,[
                            'school_name'         => v::notEmpty()->schoolExist(),
                            // 'school_code'  => v::notEmpty(),
                            'level'        => v::notEmpty(),
                            'district_id'  => v::notEmpty(),
                            // 'about'        => v::notEmpty(),
                        ]);

        // validation falied
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('school.create'));
        }

        //create a new institution
        $school = School::create([
                            'school_name'  => $request->getParam('school_name'),
                            'school_code'  => $request->getParam('school_code'),
                            'level'        => $request->getParam('level'),
                            'district_id'  => $request->getParam('district_id'),
                            'about'        => $request->getParam('about'),
                            'created_by'   => $this->auth->user()->name
                        ]);

        // flash messege
        $this->flash->addMessage('success',ucwords($school->school_name).' has been created');

        return $response->withRedirect($this->router->pathFor('school.index'));

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
        $name     = $request->getParam('school_name');
        $district = $request->getParam('district');
        $level    = $request->getParam('level');

        $search = District::leftJoin('schools','districts.id','=','schools.district_id')
                            ->where('school_name', 'like',"%$name%")
                            ->where('district_id', 'like',"%$district%")
                            ->where('level', 'like',"%$level%")
                            ->limit(12)
                            ->get();

        return $this->view->render($response,'category/school/search.twig',[
            'items' => $search
        ]);
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
        // $school = School::find($args['id']);

        $school = District::rightJoin('schools','schools.district_id','=','districts.id')
                            ->where('schools.id',$args['id'])
                            ->get();
       
        return $this->view->render($response,'category/school/edit.twig',[
            'school' => $school[0]
        ]);
    }

    /**
     * update school
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
                'school_name'   => v::notEmpty(),
                // 'school_code'=> v::notEmpty(),
                'level'         => v::notEmpty(),
                'district_id'   => v::notEmpty(),
                // 'about'      => v::notEmpty(),
        ]);

        // validation falied
        if($validate->failed())
        {
        return $response->withRedirect($this->router->pathFor('school.edit'));
        }
            //update the subject
        $school = School::find($args['id']);
      
        $school->update([
            'school_name'  => $request->getParam('school_name'),
            'school_code'  => $request->getParam('school_code'),
            'level'        => $request->getParam('level'),
            'district_id'  => $request->getParam('district_id'),
            'about'        => $request->getParam('about'),
        ]);

        // flash message
        $this->flash->addMessage('success', ucwords($request->getParam('school_name')).'  has been updated ');

        return $response->withRedirect($this->router->pathFor('school.index'));
        
    }


}