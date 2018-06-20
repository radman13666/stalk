<?php

namespace App\Controllers\Setting;

use App\Controllers\Controller;
use App\Models\User\User;

class ChangePasswordController extends Controller
{

    /**
     * Change password view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function show($request,$response,$args)
    {
        return $this->view->render($response,'setting/changepassword/changepassword.twig');
    }

    /**
     * Update password
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function update($request,$response,$args)
    {

        // getting all the fields
        $old_password = $request->getParam('old_password');
        $new_password = $request->getParam('new_password');
        $confirm_password = $request->getParam('confirm_password');

        // checking for old password
        if(!password_verify($old_password,$this->auth->user()->password))
        {
            $this->flash->addMessage('danger','Your old password is incorrect');
            return $response->withRedirect($this->router->pathFor('changepassword'));
        }

        // check if the new passwords are matching
        if($new_password != $confirm_password)
        {
            $this->flash->addMessage('danger','Confirm  new password is not matching');
            return $response->withRedirect($this->router->pathFor('changepassword'));  
        }


        // checking password lenght
        if(strlen($new_password) < 6 )
        {
            $this->flash->addMessage('danger','Password must have a minimum of 6 characters');
            return $response->withRedirect($this->router->pathFor('changepassword'));  
        }

        // change password
        $user = $this->auth->user();

        $user->update([
            'password' => password_hash($new_password,PASSWORD_DEFAULT),
        ]);

        $this->flash->addMessage('success','You have successfully changed your password');
        return $response->withRedirect($this->router->pathFor('changepassword'));  


    }

}
