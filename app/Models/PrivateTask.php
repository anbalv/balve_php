<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateTask extends Model
{
    protected $fillable = ['title', 'description', 'day_of_week', 'repeat_weekly', 'next_date', 'start_time', 'end_time', 'category', 'location', 'notes', 'user_id', 'assigned_roles'];

    public function userPrivateTasks()
    {
        return $this->hasMany(UserPrivateTask::class);
    }

    public function taskInstances()
    {
        return $this->hasMany(TaskInstance::class);
    }
}
