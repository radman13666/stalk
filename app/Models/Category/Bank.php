<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'bank_name',
        'website',
        'other_notes'
    ];

}
