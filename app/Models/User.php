<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;  //added

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;  //最後の「SoftDeletes」足した

    const ADMIN_ROLE_ID = 1;  //
    const USER_ROLE_ID = 2;  //
    // const : constants. If a variable holds data (like $fillable below on lines 26-30, like an array), and you can change the variable at any time. On the other hand, a constant also holds data, but it is always going to be one.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // user has many posts
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    // user has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    // user has many follows (user follows many users)
    public function follows(){
        return $this->hasMany(Follow::class, 'follower_id');
    }

    // user has many followers
    public function followers(){
        return $this->hasMany(Follow::class, 'followed_id');
    }

    // return true if $this user is followed
    public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
            // if exists, it returns true
            // followers() is the above function (hasMany)
    }
}
