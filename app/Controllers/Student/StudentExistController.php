<?php

namespace App\Controllers\Student;

use Carbon\Carbon as Carbon;
use App\Controllers\Controller;
use App\Models\Student\Student;
// use App\Models\Student\Course;
// use App\Models\Category\School;
// use App\Models\Category\Tribe;
// use App\Models\Category\Hostel;
// use App\Models\Category\Dropout;
// use App\Models\Student\District;
use App\Models\Student\Secondary;
// use App\Models\Category\Subcounty;
use App\Models\Student\Institution;
// use App\Models\Student\StudentSubject;

use Respect\Validation\Validator as v;

class StudentExistController extends Controller 
{

    /**
     * Return view
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response)
    {

        return $this->view->render($response, 'student/personal/exist_create.twig');

    }

    public function store($request,$response)
    {
        /**
         * Handling validation
         */

        $name        = trim(ucwords($request->getParam('name')));
        $bursary_id  = trim($request->getParam('bursary_id'));
        $level       = $request->getParam('level');
        $year_stop   = $request->getParam('year_stop');
        $year_start  = $request->getParam('year_start');

    
        $validate = $this->Validator->validate($request,[
            'name'        => v::notEmpty(),
            'level'       => v::notEmpty(),
            'year_start'  => v::notEmpty()->date(),
            'year_stop'   => v::notEmpty()->date(), 
        ]);



        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('student.exist'));
        }

        // pull student
        $student = Student::where('bursary_id','=',$bursary_id)
                            ->where('name','=',$name)
                            ->first();
        
       //    does student name match the Bursary ID
        if(!$student)
        {
            $this->flash->addMessage('danger','Student name does not match Bursary ID');
            return $response->withRedirect($this->router->pathFor('student.exist')); 
        }
        
      
        
        /**
         * Add new row
         */


        $update = $student->update([
            
            'current_state'  => 'continuing',
            'year_start'     => $year_start,
            'year_stop'      => $year_stop
            ]);


        // setting last inserted id into session
          $_SESSION['student_id'] = $bursary_id;
          $_SESSION['year_start']  = $year_start;
          $_SESSION['year_stop']  = $year_stop;

         
      /**
       * check for level
       */
  
          
          
        
          
          if( $level == 'secondary')
          {

            /**
             * Count total number of rows in the secondary table
             * 
             */
                $row_count_sec  = Secondary::where('student_id',$bursary_id)->count();
                if($row_count_sec >= 2 )
                {
                    $this->flash->addMessage('danger','This student has already been enrolled at Secondary Level, 
                                                    Please update the current Inforamation');
                    return $response->withRedirect($this->router->pathFor('student.exist'));  
                }

                // flash message
                $this->flash->addMessage('danger',' Please complete '.ucwords($create->name).' registration' );

                return $response->withRedirect($this->router->pathFor('secondary.create'));
  
          }
  
          elseif( $level == 'university' || $level == 'tertiary')
          {

                /**
                 * Count total number of rows in the secondary table
                 * 
                 */
                $row_count_in  = Institution::where('student_id',$bursary_id)->count();
                if($row_count_in >= 2 )
                {
                    $this->flash->addMessage('danger','This student has already been enrolled at Tertiary  Level, 
                                                    Please update the current Inforamation');
                    return $response->withRedirect($this->router->pathFor('student.exist'));  
                }

                $_SESSION['level'] = $level;

                // flash message
                $this->flash->addMessage('danger',' Please complete '.ucwords($create->name).' registration' );
                    return $response->withRedirect($this->router->pathFor('institution.create'));
        
                }
  
          else 
          {
              return $response->withRedirect($this->router->pathFor('student.index'));
          }
        
    }

}
