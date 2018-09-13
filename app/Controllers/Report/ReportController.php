<?php
namespace App\Controllers\Report;

use Carbon\Carbon as Carbon;
use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Student\Course;
use App\Models\Category\School;
use App\Models\Category\Hostel;
use App\Models\Student\District;
use App\Models\Student\Complain;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;
use App\Models\Student\Reason;
use App\Models\Student\StudentSubject;
use App\Models\Student\Mentor;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;


use Respect\Validation\Validator as v;

class ReportController extends Controller 
{
    /**
     * Returns generate report view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        return $this->view->render($response,'report/report.twig');

    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function generate($request,$response,$args)
    {

        $name      = $request->getParam('name');
        $district  = $request->getParam('district');
        $school    = $request->getParam('school');
        $gender    = $request->getParam('gender');
        $status    = $request->getParam('status');
        $form      = $request->getParam('form');

        $subcounty = $request->getParam('subcounty');
        $tribe     = $request->getParam('tribe');
        $bursary_id     = $request->getParam('bursary_id');
       

        $students = School::Join('students', 'schools.id','=','students.school')
                           ->where('students.name','like',"%$name%")
                           ->where('students.dist_name','like',"%$district%")
                           ->where('students.school','like',"%$school%")
                           ->where('students.gender','like',"%$gender%")
                           ->where('students.current_state','like',"%$status%")
                           ->where('students.s_form','like',"%$form%")
                           ->where('students.ethnicity','like',"%$tribe%")
                           ->where('students.subcounty','like',"%$subcounty%")
                           ->where('students.bursary_id','like',"%$bursary_id%")
                           ->where('deleted','0')
                           ->where('students.draft','0')
                           ->orderBy('students.name','ASC')
                           ->get();
      


        // $students =  Student::all();
       


        $spreadsheet = new SpreadSheet();
        $spreadsheet->getProperties()->setCreator('Alfred Ocaka')
                    ->setTitle('Spreadsheet Download')
                    ->setSubject('Summary')
                    ->setDescription('Irish Bursary Report ');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Full Name')
                    ->setCellValue('C1', 'Date of Birth')
                    ->setCellValue('D1', 'Enthnicity')
                    ->setCellValue('E1', 'Gender')
                    ->setCellValue('F1', 'School')
                    ->setCellValue('G1', 'Form')
                    ->setCellValue('H1', 'current State')
                    ->setCellValue('I1', 'District')
                    ->setCellValue('J1', 'Funder')
                    ->setCellValue('K1', 'Student Phone')
                    ->setCellValue('L1', 'Student Email')
                    ->setCellValue('M1', 'Next of Kin')
                    ->setCellValue('N1', 'Next of Kin Phone')
                    ->setCellValue('O1', '2nd Next of Kin')
                    ->setCellValue('P1', '2nd Next of Kin phone')
                    ->setCellValue('Q1', 'Reason for Drop out')
                    ->setCellValue('R1', 'Sub County')
                    ->setCellValue('S1', 'Village')
                    ->setCellValue('T1', 'Bursary ID');
                   


        $count =0;
        foreach($students as $i => $student)
        {
            // $spreadsheet->setActiveSheetIndex(0)
           $i =$i+2;
            $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$student->name);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$student->dob);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$student->ethnicity);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$student->gender);
            $spreadsheet->getActiveSheet()->setCellValue('F'.$i,$student->school_name);
            $spreadsheet->getActiveSheet()->setCellValue('G'.$i,$student->s_form);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$i,$student->current_state);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$i,$student->dist_name);
            $spreadsheet->getActiveSheet()->setCellValue('J'.$i,$student->funder);
            $spreadsheet->getActiveSheet()->setCellValue('K'.$i,$student->student_phone);
            $spreadsheet->getActiveSheet()->setCellValue('L'.$i,$student->student_email);
            $spreadsheet->getActiveSheet()->setCellValue('M'.$i,$student->parent1_name);
            $spreadsheet->getActiveSheet()->setCellValue('N'.$i,$student->parent1_phone);
            $spreadsheet->getActiveSheet()->setCellValue('O'.$i,$student->parent2_name);
            $spreadsheet->getActiveSheet()->setCellValue('P'.$i,$student->parent2_phone);
            $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,strip_tags($student->dropout_reason));
            $spreadsheet->getActiveSheet()->setCellValue('R'.$i,$student->subcounty);
            $spreadsheet->getActiveSheet()->setCellValue('S'.$i,$student->village);
            $spreadsheet->getActiveSheet()->setCellValue('T'.$i,$student->bursary_id);
        }
      

            
                // Rename worksheet
                $spreadsheet->getActiveSheet()->setTitle('Simple oc');

                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $spreadsheet->setActiveSheetIndex(0);

                // Redirect output to a client’s web browser (Xlsx)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="01simple.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit;
     }

    /**
     * Generate student summary report
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function studentSummary($request,$response)
    {

        $districts = Student::selectRaw('students.dist_name, students.level,students.current_state,students.gender, count(*)  Total')
                                    ->where('students.school','!=','')
                                    ->where('students.draft','=','0')
                                    ->where('students.deleted','=','0')
                                     ->groupBy('students.dist_name','students.current_state', 'students.level','students.gender')
                                     ->orderBy('students.level','ASC')
                                     ->get();
        
        $schools = School::selectRaw('schools.school_name, students.current_state, schools.level, students.s_form,students.gender, count(*) Total')
                            ->leftJoin('students','schools.id','=','students.school')
                            ->where('students.school','!=','')
                            // ->where('students.current_state','=','continuing')
                            ->where('students.draft','=','0')
                            ->where('students.deleted','=','0')
                            ->groupBy('schools.school_name','students.current_state','schools.level','students.s_form','students.gender')
                            ->orderBy('schools.level','ASC')
                            ->get();
                            
        /**
         * Generate EXcel
         */

        $spreadsheet = new SpreadSheet();
         $spreadsheet->getProperties()
                ->setCreator('Alfred')
                ->setTitle('Summary Report')
                ->setSubject('')
                ->setDescription('');
        
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1','ID')
                ->setCellValue('B1','School Name')
                ->setCellValue('C1','Current State')
                ->setCellValue('D1','Level')
                ->setCellValue('E1','Form')
                ->setCellValue('F1','Gender')
                ->setCellValue('G1','Total')
                ->setCellValue('H1','')
                ->setCellValue('I1','District')
                ->setCellValue('J1','Current Status')
                ->setCellValue('K1','Level')
                ->setCellValue('L1','Gender')
                ->setCellValue('M1','Total');


        
                $count =0;

                // looping through all schools
                foreach($schools as $i => $school)
                {
                    // $spreadsheet->setActiveSheetIndex(0)
                   $i =$i+2;
                    $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
                    $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$school->school_name);
                    $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$school->current_state);
                    $spreadsheet->getActiveSheet()->setCellValue('D'.$i,ucfirst($school->level));
                    $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$school->s_form);
                    $spreadsheet->getActiveSheet()->setCellValue('F'.$i,$school->gender);
                    $spreadsheet->getActiveSheet()->setCellValue('G'.$i,$school->Total);
                  
                }

                // looping through all Districts
                foreach($districts as $i => $district)
                {

                    $i = $i+3;
                    $spreadsheet->getActiveSheet()->setCellValue('H'.$i, '');
                    $spreadsheet->getActiveSheet()->setCellValue('I'.$i, ucfirst($district->dist_name));
                    $spreadsheet->getActiveSheet()->setCellValue('J'.$i, $district->current_state);
                    $spreadsheet->getActiveSheet()->setCellValue('K'.$i, $district->level);
                    $spreadsheet->getActiveSheet()->setCellValue('L'.$i, $district->gender);
                    $spreadsheet->getActiveSheet()->setCellValue('M'.$i, $district->Total);
                   

                }

              

            
                // Rename worksheet
                $spreadsheet->getActiveSheet()->setTitle('Report');

                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $spreadsheet->setActiveSheetIndex(0);

                // Redirect output to a client’s web browser (Xlsx)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.Date('Y-M-D').'.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit;

     
    }

    /**
     * Mentorship SUMMARY report
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function mentorship($request,$response,$args)
    {
        // validation
        $validator = $this->Validator->validate($request,[
            'academic_year' =>  v::notEmpty()->numeric(),
            'semester'      => v::notEmpty()
        ]);

        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('report.index'));
        }


        /**
         * Generating the spreadsheet
         */

         $year     = trim($request->getParam('academic_year'));
         $semester = $request->getParam('semester');

         $mentors  = Mentor::selectRaw('mentors.school_name, mentors.form,mentors.gender, count(*) Total ')
                            ->where('m_date','like',"%$year%")
                            ->where('semester','like',"%$semester%")
                            ->groupBy('mentors.school_name','mentors.form','mentors.gender')
                            ->get();

        $topics  = Mentor::selectRaw('mentors.topics, mentors.gender, count(*) Total ')
                        ->where('m_date','like',"%$year%")
                        ->where('semester','like',"%$semester%")
                        ->groupBy('mentors.topics','mentors.gender')
                        ->get();

         $spreadsheet = new SpreadSheet();
         $spreadsheet->getProperties()
                      ->setTitle('Mentorship Report')
                      ->setSubject('')
                      ->setDescription('');


       $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1','ID')
                    ->setCellValue('B1','Institution')
                    ->setCellValue('C1','Form')
                    ->setCellValue('D1','Gender')
                    ->setCellValue('E1','Total')
                    ->setCellValue('F1','')
                    ->setCellValue('G1','Topics')
                    ->setCellValue('H1','Gender')
                    ->setCellValue('I1','Total');
                    


        $count = 0;

        foreach( $mentors as $i => $mentor)
        {
            $i = $i+2;
            $spreadsheet->getActiveSheet()->setCellValue('A'.$i, $count+=1);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$i, $mentor->school_name);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$mentor->form);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$mentor->gender);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$mentor->Total);
        }



        foreach( $topics as $i => $topic)
        {
            $i = $i+2;
            $spreadsheet->getActiveSheet()->setCellValue('F'.$i, '');
            $spreadsheet->getActiveSheet()->setCellValue('G'.$i, $topic->topics);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$i,$topic->gender);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$i,$topic->Total);
            
        }


    
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Report');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.Date('Y-M-D').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
                

    }

    /**
     * Mentorship Full report
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function fullMentorship($request,$response,$args)
    {
        // validation
        $validator = $this->Validator->validate($request,[
            'facademic_year' =>  v::notEmpty()->numeric(),
            // 'fsemester'      => v::notEmpty()
        ]);

        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('report.index'));
        }


        /**
         * Generating the spreadsheet
         */

         $year     = trim($request->getParam('facademic_year'));
         $semester = $request->getParam('fsemester');

         $mentors  = Mentor::where('m_date','like',"%$year%")
                            ->where('semester','like',"%$semester%")
                            ->get();


         $spreadsheet = new SpreadSheet();
         $spreadsheet->getProperties()
                      ->setTitle('Mentorship Report')
                      ->setSubject('')
                      ->setDescription('');


       $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1','ID')
                    ->setCellValue('B1','Bursary ID')
                    ->setCellValue('C1','Student Name')
                    ->setCellValue('D1','Gender')
                    ->setCellValue('E1','Institution')
                    ->setCellValue('F1','Form')
                    ->setCellValue('G1','Semester/Term')
                    ->setCellValue('H1','District')
                    ->setCellValue('I1','Date')
                    ->setCellValue('J1','Disability Status')
                    ->setCellValue('K1','Topics')
                    ->setCellValue('L1','Comments')
                    ->setCellValue('M1','Mentor')
                    ->setCellValue('N1','Mentor Phone')
                    ->setCellValue('O1','Mentor Gender');
                 
                    


        $count = 0;

        foreach( $mentors as $i => $mentor)
        {
            $i = $i+2;
            $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$mentor->bursary_id);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$mentor->student_name);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$mentor->gender);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$mentor->school_name);
            $spreadsheet->getActiveSheet()->setCellValue('F'.$i,$mentor->form);
            $spreadsheet->getActiveSheet()->setCellValue('G'.$i,$mentor->semester);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$i,$mentor->district);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$i,$mentor->m_date);
            $spreadsheet->getActiveSheet()->setCellValue('J'.$i,$mentor->disability_status);
            $spreadsheet->getActiveSheet()->setCellValue('K'.$i,$mentor->topics);
            $spreadsheet->getActiveSheet()->setCellValue('L'.$i,$mentor->comments);
            $spreadsheet->getActiveSheet()->setCellValue('M'.$i,$mentor->mentor_name);
            $spreadsheet->getActiveSheet()->setCellValue('N'.$i,$mentor->mentor_phone);
            $spreadsheet->getActiveSheet()->setCellValue('O'.$i,$mentor->mentor_gender);
        }

    
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Report');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.Date('Y-M-D').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
                

    }

    /**
     * Export all complains
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function exportComplain($request,$response,$args)
    {
          /**
         * Generating the spreadsheet
         */

        $year     = trim($request->getParam('year'));
        $status = $request->getParam('status');

        $complains  = Complain::where('created_at','like',"%$year%")
                           ->where('status','like',"%$status%")
                           ->get();


        $spreadsheet = new SpreadSheet();
        $spreadsheet->getProperties()
                     ->setTitle('Complain Report')
                     ->setSubject('')
                     ->setDescription('');


      $spreadsheet->setActiveSheetIndex(0)
                   ->setCellValue('A1','ID')
                   ->setCellValue('B1','Bursary ID')
                   ->setCellValue('C1','Student Name')
                   ->setCellValue('D1','Status')
                   ->setCellValue('E1','Title')
                   ->setCellValue('F1','Body')
                   ->setCellValue('G1','Date');

       $count = 0;

       foreach( $complains as $i => $complain)
       {
           $i = $i+2;
           $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
           $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$complain->student_id);
           $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$complain->student_name);
           $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$complain->status);
           $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$complain->title);
           $spreadsheet->getActiveSheet()->setCellValue('F'.$i,$complain->body);
           $spreadsheet->getActiveSheet()->setCellValue('G'.$i,$complain->created_at);
       }

   
       // Rename worksheet
       $spreadsheet->getActiveSheet()->setTitle('Report');

       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $spreadsheet->setActiveSheetIndex(0);

       // Redirect output to a client’s web browser (Xlsx)
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment;filename="'.Date('Y-M-D').'.xlsx"');
       header('Cache-Control: max-age=0');
       // If you're serving to IE 9, then the following may be needed
       header('Cache-Control: max-age=1');

       // If you're serving to IE over SSL, then the following may be needed
       header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
       header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
       header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
       header('Pragma: public'); // HTTP/1.0

       $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
       $writer->save('php://output');
       exit;
               

    }
    
    /**
     * Export logs
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function exportLog($request,$response,$args)
    {

         /**
         * Generating the spreadsheet
         */

        $reasons  = Reason::orderBy('created_at','DESC')->get();
      

        $spreadsheet = new SpreadSheet();
        $spreadsheet->getProperties()
                     ->setTitle('Update Logs')
                     ->setSubject('')
                     ->setDescription('');


      $spreadsheet->setActiveSheetIndex(0)
                   ->setCellValue('A1','ID')
                   ->setCellValue('B1','Reason for update')
                   ->setCellValue('C1','Student ID')
                   ->setCellValue('D1','Student Name')
                   ->setCellValue('E1','Updated By')
                   ->setCellValue('F1','Updated at');
                  

       $count = 0;

       foreach( $reasons as $i => $reason)
       {
           $i = $i+2;
           $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
           $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$reason->reason);
           $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$reason->bursary_id);
           $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$reason->student_name);
           $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$reason->user_name);
           $spreadsheet->getActiveSheet()->setCellValue('F'.$i,$reason->created_at);
          
       }

   
       // Rename worksheet
       $spreadsheet->getActiveSheet()->setTitle('Report');

       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $spreadsheet->setActiveSheetIndex(0);

       // Redirect output to a client’s web browser (Xlsx)
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment;filename="'.Date('Y-M-D').'.xlsx"');
       header('Cache-Control: max-age=0');
       // If you're serving to IE 9, then the following may be needed
       header('Cache-Control: max-age=1');

       // If you're serving to IE over SSL, then the following may be needed
       header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
       header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
       header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
       header('Pragma: public'); // HTTP/1.0

       $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
       $writer->save('php://output');
       exit;
               

    }

    /**
     * get upload view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function uploadSecondary($request,$response,$args)
    {
        return $this->view->render($response,'student/upload/secondary.twig');

    }

    /**
     * upload student information
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function postuploadSecondary($request,$response,$args)
    {

      $inputFileName  = $_SERVER['DOCUMENT_ROOT'].'/stalk/storage/images/students/secondary.xlsx';

        
        $inputFileType = IOFactory::identify($inputFileName);
        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);
        
        // $sheetData = $spreadsheet->getActiveSheet();


        $worksheet = $spreadsheet->getActiveSheet();

              
        // Get the highest row and column numbers referenced in the worksheet
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        echo '<table>' . "\n";
        for ($row = 2; $row <= $highestRow; ++$row) {
            $val = array();
            echo '<tr>' . PHP_EOL;
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $value = $worksheet->getCellByColumnAndRow($col, $row);
                $val[] = $value->getValue();
                
                
            }
        //  echo   time($val[2]);

        //     die();

            $id           = $val[0];
            $name         = $val[1];
            $dob          = $val[2];
            $gender       = $val[4];
            $year_start   = $val[5];
            $entry_garde  = $val[6];
            $school       = $val[7];
            $form         = $val[8];
            $stream       = $val[9];
            $parent_name  = $val[10];
            $district     = $val[11];

            $subcounty    = $val[12];
            $village      = $val[13];
            $health       = $val[14];
            $subject      = $val[15];
            $sport        = $val[16];
            $contact      = $val[17];

         
            
            echo '<td>' .$dob. '</td>' . PHP_EOL;
            echo '</tr>' . PHP_EOL;


            $schol_id = School::where('school_name','like',"%$school%")->first();
            $district_id = District::where('district_name','like',"%$district%")->first();

             

            $create = Student::create([
                
                'name'           => trim(ucwords($name)),
                'dob'            => $dob,
                'level'          => 'secondary',
                'gender'         => trim($gender), 
                // 'ethnicity'      => $request->getParam('ethnicity'),
                'entry_grade'    => $entry_garde,
                // 'student_phone'  => trim($phone),
                // 'national_id'    => trim($national_id),
                'registration_year' => $year_start, 
                'year_start'     => $year_start,
                // 'year_stop'      => $year_stop,
                // 'uce_grade'      => $request->getParam('uce_grade'),
                // 'uace_grade'     => $request->getParam('uace_grade'),
                // 'student_email'  => strtolower(trim($email)),
                'parent1_name'   =>  $parent_name,
                'parent1_phone'  =>  $contact,
                // 'parent2_name'   => ucwords($request->getParam('parent2_name')),
                // 'parent2_phone'  => trim($request->getParam('parent2_phone')),
                'district'       => $district_id->id,
                'dist_name'      => $district,
                'subcounty'      => ucwords($subcounty),
                'village'        => ucwords($village),
                'current_state'  => 'continuing',
                'school' =>       $schol_id->id,
                's_form' =>  $form,
                'draft' =>        '0',
                // 'dropout_reason' => $request->getParam('dropout_reason'),
                // 'comments'       => nl2br($request->getParam('comments')),
                // 'notes'          => nl2br($request->getParam('notes')),
                // 'funder'         => $irish,
                // 'photo'          => $this->files->filename,
                // 'created_by'     => ucwords($this->auth->user()->name),
                // 'created_id'     => $this->auth->user()->id,

                ]);

        // Generating burasry id         
        // $year = Carbon::parse($year_start)->format('Y');
        $bursary_id = trim($create->id.$year_start);
        
        // pull the lastest student information
       
        // if(!empty($request->getParam('bursary_id')))
        // {
        //     $bursary_id = $request->getParam('bursary_id');
        // }
        // else
        // {
        //     $bursary_id = $bursary_id;
        // }

        $create->update([
            'bursary_id' => $bursary_id
        ]);


        // // setting last inserted id into session
        //  $_SESSION['student_id'] = $create->bursary_id;
        //  $_SESSION['year_start'] = $create->year_start;
        //  $_SESSION['year_stop'] = $create->year_stop;


        $secondary = Secondary::create([
            'school_id'        => $schol_id->id,
            's_form'           => $form,
            'stream'           => $stream,
            'student_id'       => $bursary_id,
            // 'student_number'   => $request->getParam('student_number'),
            // 'student_index'    => $request->getParam('student_index'),
            'fav_subject'      => $request->getParam('fav_subject'),
            'fav_sport'        => $request->getParam('fav_sport'),
            // 'created_by'       => $this->auth->user()->name,
            'myear_start'      => $year_start,
            // 'myear_stop'      => $_SESSION['year_stop'],
            ]);

           /**
         * Update student school and level
         * 
         */

           
        //   $update  = $student->update([
        // 'school'   => $secondary->school_id,
        // 's_form'   => $secondary->s_form,
        // 'draft'    => '0'
        // ]);  

        //    $student =  Student::where('bursary_id','=',$bursary_id)
        // ->orderBy('id','DESC')->first();

        

     


          
        }
        echo '</table>' . PHP_EOL;



    }


    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function university($request,$response,$args)
    {
        $inputFileName  = $_SERVER['DOCUMENT_ROOT'].'/stalk/storage/images/students/diploma.xlsx';
        
                
                $inputFileType = IOFactory::identify($inputFileName);
                $reader = IOFactory::createReader($inputFileType);
                $spreadsheet = $reader->load($inputFileName);
                
                // $sheetData = $spreadsheet->getActiveSheet();
        
        
                $worksheet = $spreadsheet->getActiveSheet();
                // Get the highest row and column numbers referenced in the worksheet

                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
        
                echo '<table>' . "\n";
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $val = array();
                    echo '<tr>' . PHP_EOL;
                    for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                        $value = $worksheet->getCellByColumnAndRow($col, $row);
                        $val[] = $value->getValue();
                        
                        
                    }
        
                    $id           = $val[0];
                    $name         = $val[1];
                    $gender       = $val[2];
                    $account      = $val[3];
                    $bank         = $val[4];
                    $accomodation  = $val[5];
                    $transport     = $val[6];
                    $upkeep        = $val[7];
                    $internship    = $val[8];
                    $desertation   = $val[9];
        
                    $nche             = $val[10];
                    $tution           = $val[11];
                    $school           = $val[12];
                    $course           = $val[13];
                    $student_number   = $val[14];
        
                    $registration_number = $val[15];
                    $year_start          = $val[16];
                    $year_stop           = $val[17];
                    $national_id         = $val[18];
        
                    $phone               = trim($val[19]);
                    $email               = $val[20];
                    $hostel              = $val[21];
                    $dob                 = $val[22];
                    $health              = $val[24];
        
        
                    $district         = $val[25];
                    $subcounty        = $val[26];
                    $village          = $val[27];
                    $irish            = $val[28];
                    $bio              = $val[29];

                    // echo $phone;
                    // die();
        
                    $schol_id = School::where('school_name','like',"%$school%")->first();
                    $district_id = District::where('district_name','like',"%$district%")->first();
        
        
                    $create = Student::create([
                        
                        'name'           => trim(ucwords($name)),
                        'dob'            => $dob,
                        'level'          => 'tertiary',
                        'gender'         => trim($gender), 
                        // 'ethnicity'      => $request->getParam('ethnicity'),
                        // 'entry_grade'    => $request->getParam('entry_grade'),
                        // 'student_phone'  => trim($phone),
                        'national_id'    => trim($national_id),
                        'registration_year' => $year_start, 
                        'year_start'     => $year_start,
                        'year_stop'      => $year_stop,
                        // 'uce_grade'      => $request->getParam('uce_grade'),
                        // 'uace_grade'     => $request->getParam('uace_grade'),
                        'student_email'  => strtolower(trim($email)),
                        // 'parent1_name'   => ucwords($request->getParam('parent1_name')),
                        // 'parent1_phone'  => trim($request->getParam('parent1_phone')),
                        // 'parent2_name'   => ucwords($request->getParam('parent2_name')),
                        // 'parent2_phone'  => trim($request->getParam('parent2_phone')),
                        'district'       => $district_id->id,
                        'dist_name'      => $district,
                        'subcounty'      => ucwords($subcounty),
                        'village'        => ucwords($village),
                        'current_state'  => 'continuing',
                        // 'dropout_reason' => $request->getParam('dropout_reason'),
                        // 'comments'       => nl2br($request->getParam('comments')),
                        'notes'          => nl2br($bio),
                        'funder'         => $irish,
                        // 'photo'          => $this->files->filename,
                        // 'created_by'     => ucwords($this->auth->user()->name),
                        // 'created_id'     => $this->auth->user()->id,

                        'school' =>       $schol_id->id,
                        's_form' =>  $form,
                        'draft' =>        '0',
        
                        ]);
        
                // Generating burasry id         
               
                $bursary_id = trim($year_start.$create->id);
               
                
                // pull the lastest student information
               
                // if(!empty($request->getParam('bursary_id')))
                // {
                //     $bursary_id = $request->getParam('bursary_id');
                // }
                // else
                // {
                //     $bursary_id = $bursary_id;
                // }
        
                $create->update([
                    'bursary_id' => $bursary_id
                ]);
        
        
                if(($schol_id->id))
                {

              
        
                 $institution = Institution::create([
                    'school_id'                => $schol_id->id,
                    // 'course_id'                => $request->getParam('course_id'),
                    'student_id'               => $bursary_id,
                    // 'qualification'            => $request->getParam('qualification'),
                    'student_number'           => $student_number,
                    'registration_number'      => $registration_number,
                    // 'hostel_id'                => $request->getParam('hostel_id'),
                    // 's_form'                   => $request->getParam('s_form'),
                    'student_bank_name'        => $bank,
                    'student_bank_account'     => $account,
                    // 'student_bank_address'     => $request->getParam('student_bank_address'),
                    // 'other_bank_name'          => $request->getParam('other_bank_name'),
                    // 'other_bank_account'       => $request->getParam('other_bank_account'),
                    // 'other_bank_address'       => $request->getParam('other_bank_address'),
                    // 'myear_start'              => $_SESSION['year_start'],
                    // 'myear_stop'              => $_SESSION['year_stop'],
                    // 'created_by'               => ucwords($this->auth->user()->name)
                ]);
                  
                 }
                 else
                 {

                 }
                  
        
        
                    echo '<td>' . $bio. '</td>' . PHP_EOL;
                    echo '</tr>' . PHP_EOL;
                }
                echo '</table>' . PHP_EOL;
        
        
                // echo '<table>' . "\n";
                // for ($row = 2; $row <= $highestRow; ++$row) {
                //     $val = array();
                //     echo '<tr>' . PHP_EOL;
                //     for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                //         $value = $worksheet->getCellByColumnAndRow($col, $row);
                //         $val[] = $value->getValue();
                        
                        
                //     }
                //     echo '<td>' . $val[0]. '</td>' . PHP_EOL;
                //     echo '</tr>' . PHP_EOL;
                // }
                // echo '</table>' . PHP_EOL;
        
                
                // die();
        
               
                // die();
        
    }

}
