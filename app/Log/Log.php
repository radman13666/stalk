<?php

namespace App\Log;

use Monolog\Logger;
use App\Models\User\User;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


class Log 
{

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Update log
     *
     * @return void
     */
    public function updateLog($method,$name,$id,$body =null)
    {

        $user = User::find($_SESSION['user']);
     
        $log = new Logger('update.log');

       
        $log->pushHandler( new StreamHandler(__DIR__.'/storage/logs/update.txt',Logger::INFO));
        $log->pushHandler( new FirePHPHandler());

        if( in_array($_SERVER['REQUEST_METHOD'],["POST","PUT","DELETE"]))
        {
            $log->info($method,[
                'login_user' => $user->name,
                'student_name' => $name,
                'Bursary_id'   => $id,
                'Reason'   => $body
            ]);

        }
      

    }

    
}