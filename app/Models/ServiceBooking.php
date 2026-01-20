<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'booking_date' => 'date',
        'booking_start_at' => 'datetime',
        'booking_end_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(CleaningServices::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ If you want history / multiple assignments keep this
    public function cleanerAssigns()
    {
        return $this->hasMany(CleanerAssign::class, 'job_id');
    }

    // ✅ Current / latest assignment (dashboard friendly)
    public function cleanerAssign()
    {
        return $this->hasOne(CleanerAssign::class, 'job_id');
    }
}
