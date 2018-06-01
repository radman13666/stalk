<?php
namespace App\Controllers\Category;

use App\Controllers\Controller;

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
        return $this->view->render($response,'category/school/index.twig');
    }

}