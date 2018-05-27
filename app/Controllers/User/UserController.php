<?php
namespace App\Controllers\User;

use App\Controllers\Controller;

class UserController extends Controller 
{

    /**
     * Retrive all users
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function index($request,$response)
    {
        return $this->view->render($response,'auth/users.twig');
    }
}