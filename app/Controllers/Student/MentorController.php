<?php
namespace App\Controllers\Student;

use App\Controllers\Controller;
use App\Models\Student\Mentor;
use App\Models\Student\Student;
use App\Models\Category\School;
use Respect\Validation\Validator as v;

class MentorController extends Controller
{


    /**
     * Return all mentorship
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $mentors = Mentor::orderBy('id','DESC')
                         ->paginate(15,['*'],'page',$request->getParam('page'));

        return $this->view->render($response,'student/mentor/index.twig',[
            'items' => $mentors
        ]);
    }

    /**
     * Return create view
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response,$args)
    {
        $disability = ['Visual','Physical','Hearing', 'Mental - Mental disability also includes Epilepsy',
                       'Deaf', 'Dumb', 'Multiple disability', 'No disability'];

        $services = ['Referral', 'One-on-One counselling', 'Parent Discussions','Career Talks/Career Counselling',
         'Access to print materials and publications available in Library and Safe Space', 'Advice on Option selections',
          'Talks by Irish Aid/STF Alumni', 'An Annual Careers Day', 'Spiritual Nurture' ];

        return $this->view->render($response,'student/mentor/create.twig',[
            'disability' => $disability,
            'services'  => $services
        ]);

    }

    /**
     * Store data
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {
        
        

        $validate  = $this->Validator->validate($request,[
            'mentor_name'      => v::notEmpty(),
            'mentor_phone'     => v::notEmpty()->phone(),
            'gender'           => v::notEmpty(),
            'district'         => v::notEmpty(),
            'semester'         => v::notEmpty(),
            // 'school_id'        => v::notEmpty(),
            'school_name'      => v::notEmpty(),
            'bursary_id'       => v::notEmpty()->bursaryStudent(),
            'name'             => v::notEmpty(),
            'age'              => v::notEmpty(),
            'disability_status'=> v::notEmpty(),
            'form'             => v::notEmpty(),
            'topics'           => v::notEmpty(),
            'm_date'           => v::date(),
            'mentor_gender'    => v::notEmpty(),
            
        ]);

 

        // validation failed
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('mentor.create'));
        }

        // 
        $mentor = Mentor::create([
            'mentor_name'      => ucwords($request->getParam('mentor_name')),
            'mentor_phone'     => $request->getParam('mentor_phone'),
            'gender'           => $request->getParam('gender'),
            'district'         => $request->getParam('district'),
            'mentor_gender'    => $request->getParam('mentor_gender'),
            'm_date'           => $request->getParam('m_date'),
            'semester'         => $request->getParam('semester'),
            'school_name'      => $request->getParam('school_name'),
            'bursary_id'       => trim($request->getParam('bursary_id')),
            'student_name'     => trim($request->getParam('name')),
            'age'              => trim($request->getParam('age')),
            'disability_status'=> $request->getParam('disability_status'),
            'form'             => $request->getParam('form'),
            'topics'           => $request->getParam('topics'),
            'comments'         => ltrim($request->getParam('comments')),
            'created_by'       => $this->auth->user()->name
        ]);

        $this->flash->addMessage('success','A new record has been successfully created');

        return $response->withRedirect($this->router->pathFor('mentor.index'));

    }

    
    /**
     * Edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
       
        $disability = ['Visual','Physical','Hearing', 'Mental - Mental disability also includes Epilepsy',
        'Deaf', 'Dumb', 'Multiple disability', 'No disability'];

        $services = ['Referral', 'One-on-One counselling', 'Parent Discussions','Career Talks/Career Counselling',
        'Access to print materials and publications available in Library and Safe Space', 'Advice on Option selections',
        'Talks by Irish Aid/STF Alumni', 'An Annual Careers Day', 'Spiritual Nurture' ];

        
        $mentor = Mentor::find($args['id']);

        return $this->view->render($response,'student/mentor/edit.twig',[
            'mentor' => $mentor,
            'disability' => $disability,
            'services'  => $services
        ]);


    }
    
    /**
     * Update
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function update($request,$response,$args)
    {

        $validate  = $this->Validator->validate($request,[
            'mentor_name'      => v::notEmpty(),
            'mentor_phone'     => v::notEmpty()->phone(),
            'gender'           => v::notEmpty(),
            'district'         => v::notEmpty(),
            'semester'         => v::notEmpty(),
            // 'subcounty_name'   => v::notEmpty(),
            // 'school_id'        => v::notEmpty(),
            'school_name'      => v::notEmpty(),
            'bursary_id'       => v::notEmpty(),
            'name'             => v::notEmpty(),
            'age'              => v::notEmpty(),
            'disability_status'=> v::notEmpty(),
            'form'             => v::notEmpty(),
            'topics'           => v::notEmpty(),
            'm_date'           => v::date(),
            'mentor_gender'    => v::notEmpty(),
            
        ]);

 

        // validation failed
        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('mentor.edit',[
                'id' => $args['id']
            ]));
        }

        $mentor = Mentor::find($args['id']);

           // 
           $mentor->update([
            'mentor_name'      => ucwords($request->getParam('mentor_name')),
            'mentor_phone'     => $request->getParam('mentor_phone'),
            'gender'           => $request->getParam('gender'),
            'district'         => $request->getParam('district'),
            'mentor_gender'    => $request->getParam('mentor_gender'),
            'm_date'           => $request->getParam('m_date'),
            'school_name'      => $request->getParam('school_name'),
            'semester'         => $request->getParam('semester'),
            'bursary_id'       => trim($request->getParam('bursary_id')),
            'student_name'     => trim($request->getParam('name')),
            'age'              => trim($request->getParam('age')),
            'disability_status'=> $request->getParam('disability_status'),
            'form'             => $request->getParam('form'),
            'topics'           => $request->getParam('topics'),
            'comments'         => ltrim(nl2br($request->getParam('comments'))),
        ]);

        $this->flash->addMessage('success','The data has been successfully updated');

        return $response->withRedirect($this->router->pathFor('mentor.index'));
    }
    
    /**
     * Show Details
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function single($request,$response,$args)
    {
        $mentor = Mentor::find($args['id']);

        return $this->view->render($response,'student/mentor/single.twig',[
            'mentor'=> $mentor
        ]);

    }


    /**
     * Search mentorship information
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {

               // getting all the fields
               $name        = ltrim($request->getParam('name'));
               $district    = $request->getParam('district');
               $school      = $request->getParam('school');
               $gender      = $request->getParam('gender');
               $form        = $request->getParam('form');
               $bursary_id  = $request->getParam('bursary_id');
               $m_date      = trim($request->getParam('m_date'));
               $mentor_name = ltrim($request->getParam('mentor_name'));
               $semester    = $request->getParam('semester');
               
       
               $mentors = Mentor::where('student_name','like',"%$name%")
                                  ->where('district','like',"%$district%")
                                  ->where('school_name','like',"%$school%")
                                  ->where('gender','like',"%$gender%")
                                  ->where('form','like',"%$form%")
                                  ->where('m_date','like',"%$m_date%")
                                  ->where('semester','like',"%$semester%")
                                  ->where('bursary_id','like',"%$bursary_id%")
                                  ->where('mentor_name','like',"%$mentor_name%")
                                  ->orderBy('created_at','DESC')
                                  ->limit(15)
                                  ->get();
        return $this->view->render($response,'student/mentor/mentor_search.twig',[
            'items' => $mentors
        ]);
    }

}