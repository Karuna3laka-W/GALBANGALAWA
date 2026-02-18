<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalOffer extends Model
{
    // Added 'theme_color' so Laravel knows it is safe to save!
    protected $fillable = [
        'title', 
        'description', 
        'badge_text', 
        'is_active', 
        'theme_color' 
    ];
}