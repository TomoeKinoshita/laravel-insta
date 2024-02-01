<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // category has many categoryPost
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }
}
