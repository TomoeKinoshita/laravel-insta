<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){
        // $request is from the form
        // $post_id is from route

        // validation
        $request->validate([
            'comment_body'.$post_id => 'required|max:150'
                // name of the input(textarea)
        ],
        [
            // custom error messages
            'comment_body'.$post_id.'.required' => 'Comment cannot be empty',
            // (ex.) comment_body3.required
            // 左側はルール、右側が表示されるエラーメッセージ
            'comment_body'.$post_id.'.max' => 'You can only have 150 characters'
        ]);

        $this->comment->body = $request->input('comment_body'.$post_id);
                                        // getting data from input
                                        // $request->body.$post_id
        $this->comment->post_id = $post_id;
        $this->comment->user_id = Auth::user()->id;
        $this->comment->save();

        // go back to previous page
        return redirect()->back();
        // use "back" b/c 2 place to use this view(on index page and each post page)
    }

    public function destroy($id){
        $this->comment->destroy($id);

        return redirect()->back();
    }
}
