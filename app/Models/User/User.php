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
        'role',
        'api_token',
        'status'
    ];

}