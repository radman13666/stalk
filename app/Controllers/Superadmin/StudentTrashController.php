<?php
namespace App\Controllers\Superadmin;


use App\Controllers\Controller;
use App\Models\Student\Course;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;

class StudentTrashController extends Controller 
{

    /**
     * Show all deleted students
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {

        $students = School::Join('students', 'schools.id','=','students.school')
        ->orderBy('students.name','ASC')
        ->where('students.deleted','0')
        ->paginate(10,['*'],'page',$request->getParam('page'));
                     
        $path = $this->files->fileDir();

        return $this->view->render($response,'student/personal/index.twig',[
        'items'       => $students,
        'path'        => $path,
        'district'    => $district,

        ]);

    }

}
