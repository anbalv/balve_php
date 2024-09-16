<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskInstance extends Model
{
    protected $fillable = ['private_task_id', 'user_id', 'date', 'status', 'assigned_points', 'earned_points'];

    public function privateTask()
    {
        return $this->belongsTo(PrivateTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
