<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    //
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(Request $request){

        if($request->search){

            $all_posts = $this->post->withTrashed()->latest()
                                    ->where('description','LIKE','%'.$request->search.'%')
                                    ->paginate(10);
            // ->paginate(n)をapplyするときは->get()を削除すること;
            // withTrashedは、all()やlatest()等、何かとセットで書く必要がある

        }else{
            $all_posts = $this->post->withTrashed()->latest()->paginate(10);
        }

        return view('admin/posts/index')->with('all_posts', $all_posts)
                                        ->with('search', $request->search);
    }

    public function hide($id){
        $this->post->destroy($id);  // soft delete

        return redirect()->back();
    }

    public function unhide($id){
        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

}
