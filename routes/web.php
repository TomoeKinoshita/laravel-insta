<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    // 'middleware' is like filter

    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');

    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');

    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');

    Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');

    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');


    // COMMENT
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
        // a variable {post_id} is b/c we need to know which post to add the comment to.
        // 上のrouteにある{id}も、{post_id}と同じくpostのidを指すが、わかりやすくするためvariable nameを変えている。

    Route::delete('/comment/{post_id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');


    // PROFILE
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
        // ここでの{id}は、post idを指す。variable nameは好きに付けて良い。上記(例:line 41)のrouteでの{id}は、post idを指す。laravelは{id}を見ただけではそれが何を指すのか理解しないが、例えばlist-item.blade.phpにて、<form action="{{ route('comment.destroy', $comment->id) }}"との記載から、this is how we tell which ID is being passed. わかりにくければ、ここの{id}を{user_id}などと書いても良い。

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    // LIKES
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
        // since we are saving a new like, use Route::post.

    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');


    // FOLLOWS
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
        // we will add a follow, so use 'post'
        // {user_id}: we will know which user to follow

    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');


    // PROFILE 2
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');


    Route::patch('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        //since we are editing/updating, use "patch"


    // ADMIN
    Route::group(['middleware' => 'admin'], function(){

        //  admin : users
        Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
        //SoftDeleteでもdeleteを使う
        Route::delete('/admin/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('admin.users.deactivate');
        //to update, use patch (soft-deleteされたitemを、activateにするとき)
        Route::patch('/admin/users/{id}/activate', [UsersController::class, 'activate'])->name('admin.users.activate');

        

        //  admin : posts
        Route::get('/admin/posts', [PostsController::class, 'index'])->name('admin.posts');
        Route::delete('/admin/posts/{id}/hide', [PostsController::class, 'hide'])->name('admin.posts.hide');
        Route::patch('/admin/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('admin.posts.unhide');

        // admin : categories
        Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('admin.categories');
        Route::post('/admin/categories/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::delete('/admin/categories/{id}/destroy', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
        Route::patch('/admin/categories/{id}/update', [CategoriesController::class, 'update'])->name('admin.categories.update');
    });

});
