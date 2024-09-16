<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'start_time', 'end_time', 'custom_link', 'pdf_file', 'user_id', 'assigned_roles', 'hidden'];

    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }
}
