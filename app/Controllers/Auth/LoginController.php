<?php
namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Models\User\User;
use App\Controllers\Controller;

use Respect\Validation\Validator as v;

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

        if($this->auth->active == false)
        {
            $this->flash->addMessage('danger','Your account has been deactivated. Please contact Admin');
        }
        else
        {
            $this->flash->addMessage('danger','Invalid credentials');
        }
       
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
    

    /**
     * Get Password reset 
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function resetPassword($request,$response)
    {

        return $this->view->render($response,'auth/reset_password.twig');

    }
    /**
     * Reset Password
     *
     * @param [type] $reques
     * @param [type] $response
     * @return void
     */
     public function password($request,$response)
     {
        $email = trim($request->getParam('email'));

        /**
         * Validate email address
         */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->flash->addMessage('danger','Please enter an email address');

            return $response->withRedirect($this->router->pathFor('auth.password'));
        }

        /**
         * Select if the account exists
         */
        $user = User::where('email',$email)->first();
        if(!$user)
        {
            $this->flash->addMessage("danger","Your account doesn't exist");
            
            return $response->withRedirect($this->router->pathFor('auth.password')); 
        }

        /**
         * Send email
         */
        $reset_code  = bin2hex(openssl_random_pseudo_bytes(16));

        $link  = "http://localhost/stalk/public/change_password/".$reset_code."/".$email;

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $headers .= 'From: <admin@irishaiddatabase.com>' . "\r\n" .
        'Reply-To: <admin@irishaiddatabase.com>';

        $message = "Dear  <strong>".ucfirst($user->name)."</strong> <br><br>,
                    We heard that you lost your Database password. Sorry about that! <br><br>
        
                    But don’t worry! You can use the following link to reset your password:<br><br>
                    ".$link."<br><br>
                    
                    Regards,<br> Admin";

        @mail($email,"Irish Aid Bursary Database Password Reset",$message,$headers);

        $this->phpMailer->sendEmail($email,"Irish Aid Bursary Database Password Reset",$message);

        /**
         * Update user
         */
        $update = $user->update([
            'reset_code' => $reset_code
        ]);

        // flash

        $this->flash->addMessage("success","Please check your email to reset your password");
        
        return $response->withRedirect($this->router->pathFor('auth.password')); 

     }

     /**
      * Confirm Reset
      *
      * @param [type] $request
      * @param [type] $response
      * @return void
      */
     public function confirmReset($request,$response, $args)
     {
        
        $user = User::where('email',$args['email'])
                     ->where('reset_code',$args['code'])
                     ->first();
       
        // 77ef917afcc6292c30db36a1dd41a769
        if(!$user)
        {
            
            $this->flash->addMessage('danger','OOops!!! Invalid token');
            return $response->withRedirect($this->router->pathFor('auth.login'));
        }

        return $this->view->render($response,'auth/confirm_password.twig',[
            'code' => $args['code'],
            'email' => $args['email']
        ]);

     }
     
     /**
      * Save confirm
      *
      * @param [type] $request
      * @param [type] $response
      * @return void
      */
     public function saveConfirm($request,$response,$args)
     {

        $password = $request->getParam('password');
        $confirm  = $request->getParam('confirm_password');

        /**
         * Checking password length
         */
        if(strlen($password) < 6)
        {
            $this->flash->addMessage('danger','Password must be a minimum of 6 characters');
            return $response->withRedirect($this->router->pathFor('auth.confirm',[
                'code' => $args['code'],
                'email' => $args['email']
            ]));

        }

        /**
         * Confirm passwords
         */
        if($password != $confirm)
        {
            $this->flash->addMessage('danger','Passwords do not match');
            return $response->withRedirect($this->router->pathFor('auth.confirm',[
                'code' => $args['code'],
                'email' => $args['email']
            ]));

        }

        /**
         * Pull user
         */
        $user = User::where('email',$args['email'])
                    ->where('reset_code',$args['code'])
                    ->first();

        $user->update([
            'password'  => password_hash($password,PASSWORD_DEFAULT),
            'reset_code' => ''
        ]);


        // 
        $this->flash->addMessage('success','Your password been successfully changed. Please login');
        return $response->withRedirect($this->router->pathFor('auth.login'));




     }


}