<?php
namespace App\Controllers\Report;

use Carbon\Carbon as Carbon;
use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Student\Course;
use App\Models\Category\School;
use App\Models\Category\Hostel;
use App\Models\Student\District;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;
use App\Models\Student\StudentSubject;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

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

        $students = School::Join('students', 'schools.id','=','students.school')
                           ->where('students.name','like',"%$name%")
                           ->where('students.dist_name','like',"%$district%")
                           ->where('students.school','like',"%$school%")
                           ->where('students.gender','like',"%$gender%")
                           ->where('students.current_state','like',"%$status%")
                           ->where('students.s_form','like',"%$form%")
                           ->where('deleted','0')
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
                    ->setCellValue('B1', 'Name')
                    ->setCellValue('C1', 'Course')
                    ->setCellValue('D1', 'Email');

        $count =0;
        foreach($students as $i => $student)
        {
            // $spreadsheet->setActiveSheetIndex(0)
           $i =$i+3;
            $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$student->name);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$student->dob);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$student->gender);
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

}
