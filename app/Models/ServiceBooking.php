<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(CleaningServices::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cleaner assignments
    public function cleanerAssigns()
    {
        return $this->hasMany(CleanerAssign::class, 'job_id');
    }
}
