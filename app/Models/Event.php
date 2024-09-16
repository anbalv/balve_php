<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'worker_id', 'attendee_id', 'title', 'description', 'start_datetime', 'end_datetime', 'event_type', 'location', 'is_recurring', 'person_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function attendee()
    {
        return $this->belongsTo(User::class, 'attendee_id');
    }
}
