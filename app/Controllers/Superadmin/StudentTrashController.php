<?php
namespace App\Controllers\Superadmin;


use Carbon\Carbon as Carbon;
use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Student\Course;
use App\Models\Category\School;
use App\Models\Category\Tribe;
use App\Models\Category\Hostel;
use App\Models\Category\Dropout;
use App\Models\Student\District;
use App\Models\Student\Secondary;
use App\Models\Category\Subcounty;
use App\Models\Student\Institution;
use App\Models\Student\StudentSubject;
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
        ->where('students.deleted','1')
        ->paginate(10,['*'],'page',$request->getParam('page'));
                     
        $path = $this->files->fileDir();

        return $this->view->render($response,'superadmin/student/index.twig',[
        'items'       => $students,
        'path'        => $path,
        'district'    => $district,

        ]);

    }

    /**
     * Restore method
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function restore($request,$response,$args)
    {
        $student = Student::find($args['id']);

        $student->update([
            'deleted' => '0'
        ]);

        // flash message
        $this->flash->addMessage('success', ucwords($student->name).'  has been  restored');
        
        return $response->withRedirect($this->router->pathFor('students.trash'));

    }


     /**
     * Search method
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {
        // getting all the fields
        $name      = $request->getParam('name');
        $district  = $request->getParam('district');
        $school    = $request->getParam('school');
        $gender    = $request->getParam('gender');
        $status    = $request->getParam('status');
        $form      = $request->getParam('form');

        $students = School::Join('students', 'schools.id','=','students.school')
                           ->where('students.name','like',"%$name%")
                           ->where('students.dist_name','like',"%$district%")
                           ->where('students.school','like',"%$school%")
                           ->where('students.gender','like',"%$gender%")
                           ->where('students.current_state','like',"%$status%")
                           ->where('students.s_form','like',"%$form%")
                           ->where('deleted','1')
                           ->orderBy('students.name','ASC')
                           ->get();
                                        
        $path = $this->files->fileDir();


        return $this->view->render($response,'superadmin/student/search.twig',[
        'items' => $students,
        'path'  => $path,
        'district' => $district
        ]);

    }

    /**
     * Download all deleted students
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function export($request,$response,$args)
    {

    }
    

}
