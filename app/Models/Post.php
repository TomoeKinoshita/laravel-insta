<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // post belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();  //
    }

    // post has many categoryPosts
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }

    // post has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // post has many likes
    public function likes(){
        return $this->hasMany(Like::class);  // we dont use "like belongsTo post" in this app
    }

    // return true if $this (<-object) post is liked
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // $this object refers to $post (calling object) in @if($post->isLiked()) on body.blade.php

        // $this->likes() = get all likes of $this post
        // where()... = in the likes, find records with user_id = logged-in user = auth user.  filtering
        // exists() = return true if where() finds existing records.  if it finds, it returns true.

        // exists means 'true' or false
        // "likes()" is from the above "public function likes()" with eloquent relationships (that is, post hasMany likes.)
    }
}
