<?php
namespace App\Api;

use App\Models\User\User;
use App\Controllers\Controller;
// use App\Models\Student\Student;


class AuthApiController  extends Controller
{

    /**
     * Authenticate
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {


        $email = $request->getParam('email');
        $password = $request->getParam('password');


        $user = User::where('email',$email)->first();
       
        if($user)
        {

            if(password_verify($password,$user->password))
            {
                return $response->withStatus(200);
            }
            else
            {
               return $response->withStatus(400);
            }

        }
        else
        {
            return $response->withStatus(200);
        }

    }
    
}