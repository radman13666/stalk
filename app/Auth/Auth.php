<?php

namespace App\Auth;

use App\Models\User\User;
use App\Models\User\Role;

class Auth 
{
    public $active = true;
   
    /**
     * Return authenticated user info
     *
     * @return void
     */
    public function user()
    {
        return User::find($_SESSION['user']);
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }
    /**
     * This method attempts authentication
     *
     * @param [string] $email
     * @param [string] $password
     * @return void
     */
    public function attempt($email,$password)
    {
        $user = User::where('email',$email)->first();

        

        if($user)
        {
            // check if user is active
          
            if(password_verify($password,$user->password))
            {
                if($user->deleted == 0){
                $_SESSION['user'] = $user->id;
                return true;
                }

                $this->active =  false;
                
                return false;
            }
           
        }
        return false;
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        return true;
    }

    /**
     * This method return user roles
     *
     * @return void
     */
    public function permission()
    {
        $role = Role::where('id','=',$this->user()->role_id)
                    ->get();

        return $role[0];

    }

}