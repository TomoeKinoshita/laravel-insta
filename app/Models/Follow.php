<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;

    // follow belongs to user (inverse of user follows)
    public function followed(){
            // public function userでもok
        return $this->belongsTo(User::class, 'followed_id')->withTrashed();
    }

    // also follow belongs to user (inverse of user followers)
    public function follower(){
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }
}
