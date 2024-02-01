<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    //
    private $like;

    public function __construct(Like $like){
        $this->like = $like;
    }

    public function store($post_id){
            // no data from the form, so no 'Request $request'. necessary variable is only post_id.

        $this->like->post_id = $post_id;
        $this->like->user_id = Auth::user()->id;
        $this->like->save();

        return redirect()->back();  // go to previous page
            // back() b/c we have 2 places: index page and show post page
    }

    public function destroy($post_id){
        //->usually destroy($id)
        $this->like->where('post_id', $post_id)  // find
                    ->where('user_id', Auth::user()->id)  // find
                    ->delete();  // delete whatever on the left.

        // "$this->like" is the connectin to likes table. see on line 15 above.

        return redirect()->back();
    }
}
