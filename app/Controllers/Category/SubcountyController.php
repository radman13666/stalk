<?php
namespace App\Controllers\Category;

use App\Controllers\Controller;
use App\Models\Student\District;
use App\Models\Category\Subcounty;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;

class SubcountyController extends Controller 

{
    /**
     * Return all subcounties
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $subcounty = Subcounty::paginate(12,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'category/subcounty/index.twig',[
        'items' => $subcounty
        ]);

    }

    /**
     * Return create view
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response)
    {
     
        return $this->view->render($response,'category/subcounty/create.twig');
    }

    /**
     * Store subcounty
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {
        // validation
     $validate = $this->Validator->validate($request,[
        'subcounty_name'     => v::notEmpty()->subcountyExist(),
        'district_name'      => v::notEmpty(),
         
      ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('subcounty.create'));
        }

        // create subcounty
        $subcounty = Subcounty::create([
            'subcounty_name' => $request->getParam('subcounty_name'),
            'district_name'  => $request->getParam('district_name')
        ]);

        // flash message
        $this->flash->addMessage('success', $subcounty->subcounty_name.' has been added');

        return $response->withRedirect($this->router->pathFor('subcounty.index'));

    }

    /**
     * Search method
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function search($request,$response)
    {

        $subcounty = $request->getParam('subcounty_name');
        $district  = $request->getParam('district_name');

        $subcounties = Subcounty::where('subcounty_name','like',"%$subcounty%")
                                ->where('district_name','like',"%$district%")
                                ->limit(12)
                                ->get();
                return $this->view->render($response,'category/subcounty/search.twig',[
                'items' => $subcounties
                ]);
    }

    /**
     * Edit
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $subcounty = Subcounty::find($args['id']);

        return $this->view->render($response,'category/subcounty/edit.twig',[
            'subcounty' => $subcounty
        ]);
    }

    /**
     * update
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
            'subcounty_name'     => v::notEmpty(),
            'district_name'      => v::notEmpty(),
            
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('subcounty.edit',[
                'id' => $args['id']
            ]));
        }
        
        // PULL SUBCOUNTY
        $subcounty = Subcounty::find($args['id']);

        $subcounty->update([
            'subcounty_name' => $request->getParam('subcounty_name'),
            'district_name'  => $request->getParam('district_name')
        ]);

        // flash message
        $this->flash->addMessage('success', $request->getParam('subcounty_name').' has been updated');

        return $response->withRedirect($this->router->pathFor('subcounty.index'));

 }

   

}