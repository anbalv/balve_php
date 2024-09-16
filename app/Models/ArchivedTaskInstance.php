<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedTaskInstance extends Model
{
    use HasFactory;

    protected $fillable = ['private_task_id', 'user_id', 'date', 'status', 'assigned_points', 'earned_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
