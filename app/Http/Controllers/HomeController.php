<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        // We'll make a separate set of data IF we have a request.
        if($request->search){
            // search data
            $home_posts = $this->post->where('description', 'LIKE', '%'.$request->search.'%')->get();
            // SELECT * FROM posts WHERE description LIKE '%farm%'
            // regex/regular expressions  // pattern of text
            // %: any letter/number
            // LIKE : is used with regex. We cannot use "=" here, it is not going to work, so instead we use LIKE. similar toのような意味

        }else{  // else の中は、normal index data, without any search
            $all_posts = $this->post->latest()->get();
            // all posts ordered by latest

            // $all_posts = [];
                // temporarily made to see the error message for no posts.

            $home_posts = [];  // empty array. going to be posts that are shown in index
            foreach($all_posts as $p){
                if($p->user_id == Auth::user()->id || $p->user->isFollowed()){
                    $home_posts [] = $p;
                }
            }
        }

        $suggested_users = array_slice($this->suggested_users(), 0, 10);
                        // array_slice is PHP function (NOT Laravel function). Instead of getting all of suggested users, limit that to up to 10 users only. taking the first 10 elements of the array.

        return view('user.index')->with('all_posts', $home_posts)
                                ->with('suggested_users', $suggested_users)
                                ->with('search', $request->search);
                                    // It's not a problem if we don't have it. If it's a normal index, and if($request->search) is going to be false, you can get normal data. What gets passed here is NULL. so this will be null to get passed the searched variable. That's OK.

    }


    private function suggested_users(){
        $suggested_users = [];  // empty array
                                // to get a list of users, we need to connect users table (上に書く)

        // to get suggested users, get all users, except logged-in user (b/c no need for my own account in suggested users list)
        $all_users = $this->user->all()->except(Auth::user()->id);

        foreach($all_users as $u){
            if(!$u->isFollowed()){  // if it's not followed yet  // ! means "not"
                $suggested_users [] = $u;
            }
        }

        return $suggested_users;
    }
}
