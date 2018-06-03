<?php

namespace App\Controllers\Category;

use App\Models\Category\Bank;
use App\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;
class BankController extends Controller
{


    /**
     * Return all Banks
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $banks = Bank::orderBy('bank_name','ASC')
                     ->paginate(12,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'category/bank/index.twig',[
            'items' => $banks,
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
        return $this->view->render($response,'category/bank/create.twig');
    }

    /**
     * save bank
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {
          
        //    Handling validation
        $validate = $this->Validator->validate($request,[
                            'bank_name'   => v::notEmpty()->bankExist()
                        ]);

        // validation falied
        if($validate->failed())
        {
        return $response->withRedirect($this->router->pathFor('bank.create'));
        }

        // create
        $bank = Bank::create([
            'bank_name'   => $request->getParam('bank_name'),
            'website'     => $request->getParam('website'),
            'other_notes' => $request->getParam('other_notes'),
        ]);

        // flash messege
        $this->flash->addMessage('success',ucwords($bank->bank_name).' has been created');
        
        return $response->withRedirect($this->router->pathFor('bank.index'));
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
        $name = $request->getParam('bank_name');

        $search = Bank::where('bank_name','like',"%$name%")
                        ->limit(12)
                        ->get();
        $this->view->render($response,'category/bank/search.twig',[
            'items' => $search
        ]);
    }


     /**
     * Return  Bank edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $bank = Bank::find($args['id']);
       
        return $this->view->render($response,'category/bank/edit.twig',[
            'bank' => $bank
        ]);
    }

    /**
     * update bank
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
                'bank_name'   => v::notEmpty(),
        ]);

        // validation falied
        if($validate->failed())
        {
        return $response->withRedirect($this->router->pathFor('bank.edit'));
        }
            //update the subject
        $bank = Bank::find($args['id']);
      
        $bank->update([
            'bank_name'   => $request->getParam('bank_name'),
            'website'     => $request->getParam('website'),
            'other_notes' => $request->getParam('other_notes'),
        ]);

        // flash message
        $this->flash->addMessage('success', ucwords($request->getParam('bank_name')).'  has been updated ');

        return $response->withRedirect($this->router->pathFor('bank.index'));
        
    }



}