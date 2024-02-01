<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
    // 下記のpublic function storeの中にあるAuthのために必要
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    //
    private $post;
    private $category;

    public function __construct(Post $post, Category $categ){
        $this->post = $post;  // connecting to post table
        $this->category = $categ;  // connecting to category table
    }

    public function create(){

        $all_categories = $this->category->all();

        return view('user.posts.create')
            ->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        // object. "$request" contains data from the form

        // validation rules
        $request->validate([
            'description' => 'required|max:1000',
            'image' => 'required|max:1048|mimes:jpeg,jpg,png,gif',
            'category_id' => 'required|array|between:1,3'
                // array here is since 'category_id' is goint to returning an array
                // between = minimum (1) and maximum (3) numbers of items in the array allowed.
        ]);


        $this->post->description = $request->description;
        $this->post->user_id = Auth::user()->id;
            // $_SESSION[]
            // Auth contains all the data of logged in user (except for password), and get the id
            // since Auth is a class, add "use Illuminate\Support\Facades\Auth;" on the top.
        $this->post->image = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
            // post tableのimage columnのtypeはlongtext.
            // convert image to longtext. save the file as long text directly in the database. (no saving in a resource folder as before.)
        $this->post->save();  // here post has already ID

        //save categorypost
        $category_post = [];  // empty array
        foreach($request->category_id as $categ_id){
                // '$request->category_id' is array of Nos., and '$categ_id' is a number that is an ID of checked categories.
                // '$request->category_id' is going to be an array, from '<input ... name="category_id[]">' from create.blade.php, which contains IDs of checked categories
            $category_post[] = ['category_id' => $categ_id];
        }
                    // now the end of loop,
                    // $category_post = [
                    //     [
                    //         'category_id' => 1,
                    //         'post_id' =>
                    //     ],
                    //     [
                    //         'category_id' => 2
                    //         'post_id' =>
                    //     ],
                    // ];
        $this->post->categoryPosts()->createMany($category_post);
            // id of the latest post. we already has post ID in "「$this->post」->save();" above.
            // 'create' accepts only 1 record, on the other hand, 'createMany' accepts many records at once.
            // 'categoryPosts()' comes from Post.php, which "hasMany(CategoryPost::class)".

        // go back to index
        return redirect()->route('index');
    }

    public function show($id){
        $post_a = $this->post->findOrFail($id);
        // SELECT * FROM posts WHERE id=$id

        return view('user.posts.show')->with('post', $post_a);
    }

    public function edit($id){
        // data of post
        $post_a = $this->post->findOrFail($id);

        // list of all categories
        $all_categories = $this->category->all();

        // list of selected categories
        $selected_categories = [];  // empty array
        foreach($post_a->categoryPosts as $category_post){
            $selected_categories[] = $category_post->category_id;
        }

        return view('user.posts.edit')
                ->with('post', $post_a)
                ->with('all_categories', $all_categories)
                ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){  // request is from form, id is being passed from route

        // validation
        $request->validate([  // copied from above "public function store"
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpeg,jpg,png,gif',
                    // image is not required here, so doesn't include "required"
            'category_id' => 'required|array|between:1,3'
        ]);

        // find the record to update
        $post_a = $this->post->findOrFail($id);

        // updateしたいpostを見つけたら、get the description from the form
        $post_a->description = $request->description;

        // Next: image is not required. Check if form has new image update
        if($request->image){  // copied from above "public function store"
            $post_a->image = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));  // convert image to longtext
        }
        $post_a->save();

        // delete categoryPosts (anyway)
        $post_a->categoryPosts()->delete();
        // using eloquent relationship. find all the related categoryPosts, and delete all those.
        // different from destroy($id). destroy needs $id.

        // then newly add categoryPosts
        $category_posts = [];  // make an empty array
        foreach($request->category_id as $categ_id){
            // we're looping through the categories that are checked in the form, and each of those has an ID.
            $category_posts[]= ['category_id' => $categ_id];
            // for each item there, we're going to insert it inside our array.
            // inserting the array (right) into the big array (left).
        }

                // the above is like
                // $category_posts = [
                //     [
                //         'category_id' => 1
                //     ],
                //     [
                //         'category_id' => 2
                //     ]
                //     ];

        $post_a->categoryPosts()->createMany($category_posts);
        // create function with the category_id
        // missing post id is from $post_a

        // (after saving all the category posts,) go to post.show
        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        // $this->post->destroy($id);

        // or
        // $post_a = $this->post->findOrFail($id);
        // $post_a->delete();
            // delete whatever on the left.

        $post_a = $this->post->findOrFail($id);
        $post_a->forceDelete();
            // permanent delete, even if you have soft deletes enabled.

        return redirect()->route('index');
    }


}
