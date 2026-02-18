<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model 
{ 
    protected $fillable = ['title', 'subtitle', 'image_path', 'is_active']; 
}