<?php
namespace App\Helpers;

use Slim\Http\Request;
use Slim\Http\Response;

class Files 
{
    public $filename;

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

}