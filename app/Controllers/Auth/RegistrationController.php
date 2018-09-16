<?php

namespace App\Controllers\Auth;

use App\Models\User\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class RegistrationController extends Controller
{

    /**
     * Return registration view
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response)
    {
        return $this->view->render($response,'auth/create.twig');

    }

    public function store($request,$response)
    {
        /**
         * Handling validation
         */
        $Validator = $this->Validator->validate($request,[
                                'name' => v::notEmpty(),
                                'email' => v::email()->emailExist(),
                                'phone' => v::phone()->phoneExist(),
                                'role'  => v::notEmpty()
                            ]);
        
        // is validation failed
        if($Validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('auth.register'));
        }

        /**
         * Generating random password and api token
         */
        $name = $request->getParam('name');
        $email = $request->getParam('email');

        $token  = openssl_random_pseudo_bytes(16);
        $api_token = bin2hex($token);

        $password = $api_token;

        //  password
       
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $headers .= 'From: <admin@irishaiddatabase.com>' . "\r\n" .
        'Reply-To: <admin@irishaiddatabase.com>';

        $link  = "http://".$_SERVER['HTTP_HOST']."/stalk/public/";
        

        $message = "Dear  <strong>".ucfirst($name)."</strong>, <br><br>
                    Your password for the Irish Aid Bursary Database is <strong>".$password."</strong> .<br><br>

                    Please click this link to login
                    <br>

                    <a href='".$link."'>'".$link."'</a><br>
                    Regards,<br><br>
                    Admin<br><br><br>
                    THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL";


    
       @mail($email,"Irish Aid Bursary Scheme Password",$message,$headers);
   
       
        User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'phone'    => $request->getParam('phone'),
            'role_id'  => $request->getParam('role'),
            'api_token' => $api_token,
        ]);

        // flash message
        $this->flash->addMessage('success','A new user  has been successfully added ');

        return $response->withRedirect($this->router->pathFor('user.index'));

    }

}