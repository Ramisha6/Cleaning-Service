<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    // Allow mass assignment
    protected $guarded = [];

    // Cast fields properly
    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
    ];
}
