<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $fillable = ['user_id', 'reward_id', 'booked_at', 'status'];

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
