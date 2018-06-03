<?php

namespace App\Helpers;

use App\Models\User\Role;
use App\Models\Category\Level;
use App\Models\Category\Funder;
use App\Models\Category\Bank;
use App\Models\Category\School;
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






}