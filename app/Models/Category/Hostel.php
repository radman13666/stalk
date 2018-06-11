<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = [
        'hostel_name',
        'hostel_address',
        'owner_name',
        'owner_phone',
        'owner_email',
        'deleted_at',
        'deleted_by',
        'status',
    ];

}
