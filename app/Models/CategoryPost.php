<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    public $timestamps = false;
        // no timestamp columns needed in pivot table

    protected $table = "category_post";
        // telling the table name
        // since this is not standard plural name, we are going to tell laravel what the table name is.
        // if we don't have this, laravel will look for category_post"s" table. (standard plural name in laravel)

    protected $fillable = ['category_id', 'post_id'];
        //$fillableは常にprotectedで。
        // create function のために記載必要
        // $fillable is list of columns that you can put inside array before you use create function


    // categoryPost belongs to category
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // categoryPost belongs to post (not going to be used)
    public function post(){
        return $this->belongsTo(Post::class)->withTrashed();
    }


}
