<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class Subcounty extends Model
{
    protected $table = 'subcounties';
    
    protected $fillable = [
        'subcounty_name',
        'district_name',
    ];

}
