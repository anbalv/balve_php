<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrivateTask extends Model
{
    protected $fillable = ['user_id', 'private_task_id', 'status', 'assigned_points', 'earned_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function privateTask()
    {
        return $this->belongsTo(PrivateTask::class);
    }
}
