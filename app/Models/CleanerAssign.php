<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleanerAssign extends Model
{
    protected $guarded = [];

    public function cleaner()
    {
        return $this->belongsTo(User::class, 'cleaner_id');
    }

    // public function job()
    // {
    //     return $this->belongsTo(ServiceBooking::class, 'job_id');
    // }

    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, 'job_id');
    }
}
