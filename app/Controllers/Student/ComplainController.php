<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\User\User;
use App\Models\Student\Complain;
use App\Models\Student\Student;
use Illuminate\Pagination\Paginator;
use App\Models\Student\ComplainReply;
use Respect\Validation\Validator as v;

class ComplainController extends Controller 
{
  
    /**
     * Store students  complains
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function store($request,$response)
    {

          // validation
        $validate = $this->Validator->validate($request,[
            'title'     => v::notEmpty(),
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('student.profile'));
        }

        // create a course
        Complain::create([
            'title'        => $request->getParam('title'),
            'body'         => $request->getParam('body'),
            'student_id'   => $_SESSION['student'],
            'student_name' => $this->auth->studentProfile()->name,
            
        ]);



         /**
         * Send email
         */

             $user = User::where('role_id','=','6')->first();
        
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
                $message = "Dear  <strong>".ucfirst($user->name)."</strong> <br><br>,
                            You have received a grievance from a student! <br><br>
                            <h2>".$request->getParam('title')."</h2> <br><br>
                            Please login the databse to view more details<br>

                            Regards,<br> Admin";
        
                @mail($user->email,$request->getParam('title').'- Student Grievance',$message,$header);



        $this->flash->addMessage('success',ucfirst($request->getParam('title')).' has been submitted');

        return $response->withRedirect($this->router->pathFor('student.profile'));
    }

    /**
     * Show complain details
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function show($request,$response,$args)
    {
        $complain = Complain::find($args['id']);

        $replies  = ComplainReply::where('complain_id',$args['id'])
                                  ->where('student_id',$this->auth->studentProfile()->bursary_id)
                                  ->orderBy('id','ASC')
                                  ->get();

        $path = $this->files->fileDir();

        return $this->view->render($response,'complains/student/single.twig',[
            'complain' => $complain,
            'replies'  => $replies,
            'path'     => $path
        ]);

    }

    /**
     * Store Student  Replies
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function saveReply($request,$response,$args)
    {

        /**
         * Validation
         */
        
        $validate = $this->Validator->validate($request,[
            'reply'     => v::notEmpty(),
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('complain.show',[
                'id' => $args['id']
            ]));
        }

        $reply = ltrim(nl2br($request->getParam('reply')));

     
        // new reply
        $reply = ComplainReply::create([
            'message'        => $reply,
            'complain_id'    => $args['id'],
            'user_name'       => ucwords($this->auth->studentProfile()->name) ,
            'role'            => '0',
            'student_id'      => $this->auth->studentProfile()->bursary_id

        ]);

        $this->flash->addMessage('success','Message sent');

        return $response->withRedirect($this->router->pathFor('complain.show',[
            'id' => $args['id']
        ]));

    }

    /**
     * Return all complains
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $replies = Student::Join('complains','students.bursary_id','=','complains.student_id')
                            ->orderBy('complains.id','DESC')
                            ->paginate(15,['*'],'page',$request->getParam('page'));
        
        return $this->view->render($response,'complains/admin/complain_index.twig',[
            'items' => $replies
        ]);

    }

    /**
     * Search complains
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {
        $name        = $request->getParam('name');
        $bursary_id  = $request->getParam('bursary_id');
        $year        = $request->getParam('year');
        $status      = $request->getParam('status');
         
         
        $replies = Student::Join('complains','students.bursary_id','=','complains.student_id')
                            ->orderBy('complains.id','DESC')
                            ->where('students.name','like',"%$name%")
                            ->where('complains.student_id','like',"%$bursary_id%")
                            ->where('complains.created_at','like',"%$year%")
                            ->where('complains.status','like',"%$status%")
                            ->paginate(15,['*'],'page',$request->getParam('page'));
        
        return $this->view->render($response,'complains/admin/complain_index.twig',[
            'items' => $replies
        ]);
    }

    /**
     * Display single on a single page
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function single($request,$response,$args)
    {
        $complain = Complain::find($args['id']);

        $replies = ComplainReply::where('complain_id',$complain->id)
                                    ->orderBy('id','DESC')
                                    ->get();

        $path = $this->files->fileDir();

        $student  = Student::leftJoin('complains','students.bursary_id','=','complains.student_id')
                            ->where('bursary_id',$complain->student_id)
                            ->where('user_id','')
                            ->first();

        $admin = User::leftJoin('complains','complains.user_id','=','users.id')
                      ->where('complains.user_id',$this->auth->user()->id)
                      ->where('complains.student_id','')
                      ->first();


        return $this->view->render($response,'complains/admin/single.twig',[
            'complain' => $complain,
            'replies'  => $replies,
            'path'     => $path,
            'student'  => $student,
            'admin'    => $admin,
        ]);

    }

    /**
     * Post Complain-complain Manager and Admin
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function postComplain($request,$response,$args)
    {
        $reply = ltrim(nl2br($request->getParam('reply')));

        $complain = Complain::find($args['id']);

        
        // new reply
        $reply = ComplainReply::create([
            'message'        => $reply,
            'complain_id'    => $args['id'],
            'user_name'      => ucwords($this->auth->user()->name),
            'role'           => '1',
            'student_id'     => $complain->student_id,
            'user_id'        => $this->auth->user()->id

        ]);

        $this->flash->addMessage('success','Message sent');

        return $response->withRedirect($this->router->pathFor('complain.single',[
            'id' => $args['id']
        ]));

    }

    /**
     * Close the ticket
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function closed($request,$response,$args)
    {
        $complain = Complain::find($args['id']);

        $complain->update(['status' => 'closed']);

        $this->flash->addMessage('success','You have successfully closed this ticket');

        return $response->withRedirect($this->router->pathFor('complain.index',[
            'id' => $args['id']
        ]));
    }

    /**
     * Open the ticket
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function reopen($request,$response,$args)
    {
        $complain = Complain::find($args['id']);

        $complain->update(['status' => 'pending']);

        $this->flash->addMessage('success',' Operation successful');

        return $response->withRedirect($this->router->pathFor('complain.index',[
            'id' => $args['id']
        ]));
    }


}
