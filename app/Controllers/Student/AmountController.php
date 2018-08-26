<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\Student\Amount;
use App\Models\Student\Student;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;
use Illuminate\Pagination\Paginator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Respect\Validation\Validator as v;

class AmountController extends Controller 
{

    /**
     * Return all amount paid
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function  index($request,$response,$args)
    {

        $student = Student::where('bursary_id','=',$args['id'])->first();
        
          //check student institution category
          if($student->level == 'university' || $student->level == 'tertiary' )
          {
               $institute = Institution::where('student_id',$student->bursary_id)->get();
               $forms = ['Year One','Year Two','Year Three','Year Four','Year Five'];
               $term  = ['Semester One','Semester Two'];
               
          }
          
          // pull other student information
          if($student->level == 'secondary' )
          {
              $institute = Secondary::where('student_id',$student->bursary_id)->get();
              $forms = ['S1','S2','S3','S4','S5','S6'];
              $term  = ['Term One','Term Two','Term Three'];
            
          }
     
          

            //  Retrieve all amount
        $amount = Amount::where('student_id', '=', $student->bursary_id)
                            ->paginate(5,['*'],'page',$request->getParam('page'));
        


        return $this->view->render($response,'student/personal/amount_edit.twig',[
            'info'        => $institute[0],
            'items'      => $amount,
            'student'     => $student,
            'forms'       => $forms,
            'path'        => $this->files->fileDir(),
            'term'        => $term,
           
        ]);

    }

    /**
     * Store Amount
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {
     

        // validation
        $validate = $this->Validator->validate($request,[
            'amount' => v::notEmpty(),
            // 'reason'=> v::notEmpty(),
            'form'  => v::notEmpty(),
            // 'bank'  => v::notEmpty(),
            'year'  => v::notEmpty(),
            'term'  => v::notEmpty(),
           
        ]);

        // failed
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('amount.index',[
                'id' => $args['id']
            ]));
        }

   
     
            // create a new
        $result = Amount::create([
            'student_id'   => trim($request->getParam('student_id')),
            'amount'       => $request->getParam('amount'),
            'reason'       => $request->getParam('reason'),
            'form'         => $request->getParam('form'),
            'bank'         => $request->getParam('bank'),
            'year'         => $request->getParam('year'),
            'term'         => $request->getParam('term'),
            'created_by'   => $this->auth->user()->name,
        ]);
            
     
           
       

        // flash messages
        $this->flash->addMessage('success','Amount has been successfully added');

        return $response->withRedirect($this->router->pathFor('amount.index',[
            'id' =>$args['id']
        ]));

    }

    /**
     * Export Payment Details
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function export($request,$response,$args)
    {
     
        
        $students = Amount::where('student_id','=',$args['id'])
                           ->orderBy('amount.id','ASC')
                           ->get();

        // pull student info
        $info    = Student::where('bursary_id','=',$args['id'])->first();


        $spreadsheet = new SpreadSheet();
        $spreadsheet->getProperties()->setCreator('Alfred Ocaka')
                     ->setTitle('Spreadsheet Download')
                     ->setSubject('Summary')
                    ->setDescription('Irish Bursary Report ');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'ID')
        ->setCellValue('B1', 'Full Name')
        ->setCellValue('C1', 'Student ID')
        ->setCellValue('D1', 'Form')
        ->setCellValue('E1', 'Term/Semester')
        ->setCellValue('F1', 'Amount')
        ->setCellValue('G1', 'Bank')
        ->setCellValue('H1', 'Reason')
        ->setCellValue('I1', 'Date of Payment');
  

        $count =0;
        foreach($students as $i => $student)
        {
        // $spreadsheet->setActiveSheetIndex(0)
        $i =$i+3;
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$count+=1);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$info->name);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$info->bursary_id);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$student->form);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$student->term);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,$student->amount);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,$student->bank);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,$student->reason);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,$student->year);
        }



        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('First');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.date('d-m-Y').'.xlsx"');
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