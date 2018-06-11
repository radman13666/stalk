<?php

namespace App\Controllers\Category;

use App\Controllers\Controller;
use App\Models\Category\Hostel;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;


class HostelController extends Controller
{
   
    /**
     * Return all hostels
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $rags
     * @return void
     */
    public function index($request,$response,$rags)
    {
        $hostels = Hostel::orderBy('hostel_name','ASC')
                         ->paginate(12,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'category/hostel/index.twig',[
            'items' => $hostels
        ]);
    }

    /**
     * Hostel create view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function create($request,$response, $args)
    {
       
        return $this->view->render($response,'category/hostel/create.twig');
    }

    /**
     * store 
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {
          // validation

          $validator = $this->Validator->validate($request,[
            'hostel_name'     => v::notEmpty(),
            'owner_name'      => v::notEmpty(),
            'owner_phone'     => v::phone(),
            // 'hostel_address'  => v::notEmpty(),
            // 'owner_email'     =>  v::notEmpty()
        ]);

        // validation failed
        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('hostel.create'));
        }

        // create a new hostel

        $hostel = Hostel::create([
            'hostel_name'     => $request->getParam('hostel_name'),
            'owner_name'      => $request->getParam('owner_name'),
            'owner_phone'     => $request->getParam('owner_phone'),
            'hostel_address'  => $request->getParam('hostel_address'),
            'owner_email'     => $request->getParam('owner_email')
        ]);

        $this->flash->addMessage('success',ucwords($hostel->hostel_name).'  has been successfully added');

        return $response->withRedirect($this->router->pathFor('hostel.index'));

    }

    /**
     * Search
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {
        $hostel = $request->getParam('hostel_name');
        $name   = $request->getParam('owner_name');
        $phone  = $request->getParam('owner_phone');

        $select = Hostel::where('hostel_name','like',"%$hostel%")
                        ->where('owner_name','like',"%$name%")
                        ->where('owner_phone','like',"%$phone%")
                        ->limit(12)
                        ->get();

        return $this->view->render($response,'category/hostel/search.twig',[
            'items' => $select
        ]);

    }
    
    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $hostel = Hostel::find($args['id']);

        return $this->view->render($response,'category/hostel/edit.twig',[
            'hostel' => $hostel
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
         // validation

             $validator = $this->Validator->validate($request,[
                'hostel_name'     => v::notEmpty(),
                'owner_name'      => v::notEmpty(),
                'owner_phone'     => v::phone(),
                // 'hostel_address'  => v::notEmpty(),
                // 'owner_email'     =>  v::notEmpty()
            ]);
    
            // validation failed
            if($validator->failed())
            {
                return $response->withRedirect($this->router->pathFor('hostel.create'));
            }

            // find hostel
            $hostel  = Hostel::find($args['id']);

    
            // create a new hostel
    
            $update = $hostel->update([
                'hostel_name'     => $request->getParam('hostel_name'),
                'owner_name'      => $request->getParam('owner_name'),
                'owner_phone'     => $request->getParam('owner_phone'),
                'hostel_address'  => $request->getParam('hostel_address'),
                'owner_email'     => $request->getParam('owner_email')
            ]);
    
            $this->flash->addMessage('success',' Hostel  has been successfully updated');
    
            return $response->withRedirect($this->router->pathFor('hostel.edit',[
                'id' => $args['id']
            ]));

    }

}