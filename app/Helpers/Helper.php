<?php

namespace App\Helpers;

use App\Models\User\Role;
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

}