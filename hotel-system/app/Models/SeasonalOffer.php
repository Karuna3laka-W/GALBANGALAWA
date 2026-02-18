<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SeasonalOffer extends Model
{
    protected $fillable = ['title', 'description', 'badge_text', 'is_active'];
}
