<?php
namespace App\Controllers;

class HomeController  extends Controller
{

    /**
     * home
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function index($request,$response)
    {
        return $this->view->render($response,'dashboard/dashboard.twig');

    }


}