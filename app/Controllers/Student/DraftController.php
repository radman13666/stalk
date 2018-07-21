<?php
namespace App\Controllers\Student;

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

class DraftController extends Controller 
{

    /**
     * Return all drafts
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $students = Student::where('draft','=','1')
                            ->where('created_id',$_SESSION['user'])
                            ->paginate(12,['*'],'page', $request->getParam('page'));

        $path = $this->files->fileDir();    
         
        return $this->view->render($response,'student/draft/index.twig',[
            'items'       => $students,
            'path'        => $path,
            'district'    => $district,    
            
        ]);
    }

    /**
     * Edit draft
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
       
        $level = Student::where('bursary_id','=',$args['id'])->first();
        
        // flash message
        $this->flash->addMessage('danger',' Please complete '.ucwords($level->name).' registration' );

        $_SESSION['student_id'] = $level->bursary_id;
        
        if( $level->level == 'secondary')
        {
          $secondary = Secondary::where('student_id',$level->bursary_id)->get();
          $count = Secondary::where('student_id',$level->bursary_id)->count();

            // delete the record in secondary table
             ($secondary[0]->exists && $count > 1) ? $secondary[0]->delete() :'';
      
         return $response->withRedirect($this->router->pathFor('secondary.create'));

        }

        elseif( $level->level == 'university' || $level->level == 'tertiary')
        {
            $institution = Institution::where('student_id',$level->bursary_id)->get();

        
            // delete the record in institution table table
            
            $institution[0]->exists ? $institution[0]->delete() : '';
            
            
            return $response->withRedirect($this->router->pathFor('institution.create'));

        }

        else 
        {
            return $response->withRedirect($this->router->pathFor('student.index'));
        } 

    }

}
   
