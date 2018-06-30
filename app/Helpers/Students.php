<?php

namespace App\Helpers;

use App\Models\User\Role;
use App\Models\Student\Student;

class Students 
{
    
   /**
    * This method updates students' school id and form
    *
    * @param [int] $student_id
    * @param [int] $school
    * @return void
    */
    public function schoolForm($student_id,$school)
    {
       
        $student =  Student::find($student_id);

        $update  = $student->update([
                'school'   => $school->school_id,
                's_form'   => $school->s_form,
            ]);

        return $update;

    }

    // 
    public function drafts()
    {
        $drafts = Student::where('draft','=','1')
                        ->where('created_id',$_SESSION['user'])
                        ->count();

     return $drafts;


    }

}