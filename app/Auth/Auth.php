<?php

namespace App\Auth;

use App\Models\User\User;

class Auth 
{
   
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
            if(password_verify($password,$user->password))
            {
                $_SESSION['user'] = $user->id;
                return true;
            }
            return false;
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

}