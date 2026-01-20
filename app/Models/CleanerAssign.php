<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ServiceBooking;

class CleanerAssign extends Model
{
    protected $guarded = [];

    // cleaner relation
    public function cleaner()
    {
        return $this->belongsTo(User::class, 'cleaner_id');
    }

    // booking relation
    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, 'job_id');
    }
}
