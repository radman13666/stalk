<?php
namespace App\Helpers;

use Slim\Http\Request;
use Slim\Http\Response;

class Files 
{
    public $filename;

    public $directory;

    //
    public function uploadFile($request,$field)
    {
        
        $file = $request->getUploadedFiles();

        $newFile = $file[$field];

        if($newFile->getError()=== UPLOAD_ERR_OK)
        {
            // Directory
            $directory = $_SERVER['DOCUMENT_ROOT'].'/stalk/storage/images/students/';

            // File name
            $this->filename = time().$newFile->getClientFilename();

            (is_writable($directory))? $newFile->moveTo($directory.$this->filename): '';   

        }
    }

    // return directory]
    public function fileDir()
    {
        $directory = 'http://'.$_SERVER['HTTP_HOST'].'/stalk/storage/images/students/';
        return $directory;
    }

    // root path
    public function rootPath()
    {
        $root = $_SERVER['DOCUMENT_ROOT'].'/stalk/storage/images/students/';
        return $root;

    }

}