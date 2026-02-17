<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'is_active',
        'has_offer',      // <--- Added
        'offer_percent'   // <--- Added
    ];

    protected $attributes = [
        'is_active' => true,
        'has_offer' => false,
    ];
}