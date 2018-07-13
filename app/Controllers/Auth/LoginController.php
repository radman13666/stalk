<?php
namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Controllers\Controller;

class LoginController extends Controller 
{


    /**
     * Return login 
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function index($request,$response,$args)
    {
        $logo = 'http://'.$_SERVER['HTTP_HOST'].'/stalk/storage/images/logo/straighttalk.jpeg';
        $irish = 'http://'.$_SERVER['HTTP_HOST'].'/stalk/storage/images/logo/irishlogo.jpg';
        return $this->view->render($response,'home.twig',[
            'logo' => $logo,
            'irish' => $irish
        ]);
    }

    /**
     * Authtenticate user
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function authenticate($request,$response)
    {
        $email    = $request->getParam('email');
        $password = $request->getParam('password');

        if($this->auth->attempt($email,$password))
        {
           return $response->withRedirect($this->router->pathFor('dashboard'));
        }
        $this->flash->addMessage('danger','Invalid email  or password');
        return $response->withRedirect($this->router->pathFor('auth.login'));

    }

    /**
     * Logout authenticated user
     *
     * @return void
     */
    public function logout($request,$response)
    {
        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.login'));
    }


}