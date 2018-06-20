<?php

namespace App\Helpers;

use App\Models\User\Role;
use App\Models\Category\Level;
use App\Models\Category\Form;
use App\Models\Category\Funder;
use App\Models\Category\Bank;
use App\Models\Category\School;
use App\Models\Category\Hostel;
use App\Models\Student\Course;
use App\Models\Student\Subject;
use App\Models\Student\District;
/**
 * This contains all helper methods
 */
class Helper 
{

    /**
     * Returns all roles
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allRoles($request,$response)
    {
        $roles = Role::all();

        return $roles;

    }

    /**
     * All District
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allDistricts($request,$response)
    {
        return District::orderBy('district_name','ASC')->get();
    }

    /**
     * Levels
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allLevels($request,$response)
    {
        return Level::all();
    }

    /**
     * All subjects
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allSubjects($request,$response)
    { 
        return Subject::where('deleted','0')->orderBy('name','ASC')->get();

    }

    /**
     * Return all secondary schools
     *
     * @return void
     */
    public function allSecondary()
    {
        return School::where('level','secondary')->get();
    }

     /**
     * Return all tertiary institution
     *
     * @return void
     */
    public function allTertiary()
    {
        return School::where('level','tertiary')->get();
    }


     /**
     * Return all universities
     *
     * @return void
     */
    public function allUniversity()
    {
        return School::where('level','university')->get();
    }

    /**
     * Return both tertiary and universities
     *
     * @return void
     */
    public function allInstitutions()
    {
      $institutes = School::where('level','university')
                         ->orWhere('level','tertiary')
                         ->get();
       return $institutes;
    }

    /**
     * Return both tertiary and universities
     *
     * @return void
     */
    public function allSchools()
    {
      $schools = School::orderBy('school_name','ASC')->get();
       return $schools;
    }



     /**
     * Return all funders
     *
     * @return void
     */
    public function allFunders()
    {
        return Funder::orderBy('funder_name','ASC')->get();
    }


    /**
     * Return all banks
     *
     * @return void
     */
    public function allBanks()
    {
        return Bank::orderBy('bank_name','ASC')->get();
    }


    /**
     * Return all hostels
     *
     * @return void
     */
    public function allHostels()
    {
        return Hostel::orderBy('hostel_name','ASC')->get();
    }


  /**
     * All Courses
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allCourses()
    { 
        return Course::where('deleted','0')->orderBy('name','ASC')->get();

    }


    /**
     * All Forms
     * @return void
     */
    public function allForms()
    { 
        return Form::orderBy('form_name','ASC')->get();

    }

    /**
     * Displaying the logo
     *
     * @return void
     */
    public function logo()
    {
        return 'http://'.$_SERVER['HTTP_HOST'].'/stalk/storage/images/logo/straighttalk.jpeg';
    }

}