<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    // This allows the seeder and forms to "fill" these columns
    protected $fillable = [
        'name', 
        'description', 
        'price'
    ];
}