<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model 

{
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'api_token',
        'status',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

}