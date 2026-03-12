<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'check_in',
        'check_out',
        'adults',
        'children',
        'room_type',
        'package_id',
        'service_ids',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'special_requests',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'service_ids' => 'array',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
