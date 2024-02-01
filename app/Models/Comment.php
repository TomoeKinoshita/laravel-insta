<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // comment belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
            // we dont make user hasMany comments
    }
}
