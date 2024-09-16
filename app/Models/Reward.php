<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = ['title', 'description', 'points', 'image_url', 'quantity'];

    public function userRewards()
    {
        return $this->hasMany(UserReward::class);
    }
}
