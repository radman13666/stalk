<?php
namespace App\Api;

use App\Models\User\User;
use App\Controllers\Controller;
// use App\Models\Student\Student;


class AuthApiController  extends Controller
{

    public $response = [];
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
       
        // User does not exist
        if(!$user)
        {
            $this->response = ['message' => 'Invalid credentials','error'=> true];
            return $response->withJson($this->response);
        }

        if($user->deleted == 1)
        {
            $this->response = ['message' => 'Your Account has been deactivated','error'=> true];
            return $response->withJson($this->response);

        }

        // checking for user permission
        if(!in_array($user->role_id,[2,3,4,5]))
        {
            $this->response = ['message' => 'You do not have enough permission','error' => true];
            return $response->withJson($this->response);
        }


        // verify password
        if(password_verify($password,$user->password))
        {
            $this->response = [
                                'id'        => $user->id,
                                'email'     => $email,
                                'api_token' => $user->api_token,
                                'message'   => 'You have successfully signin',
                                'error'     => false
                            ];
            return $response->withJson($this->response);
        }
        else
        {
            $this->response = ['message' => 'Invalid login credentials','error' => true];
            return $response->withJson($this->response);  
        }
          

      

    }
    
}