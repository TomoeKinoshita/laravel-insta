<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    //
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->orderBy('name')->paginate(10);

        $all_posts = $this->post->all();  // need list of all posts.
        $uncategorized_count = 0;  // initialize this at 0
        foreach($all_posts as $p){  // look at each post,
            if($p->categoryPosts->count() == 0){  // then count which posts do not have categories
                $uncategorized_count++;  // ++ : add 1 to the number of uncategorized_count
            }
        }

        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = $request->name;
        $this->category->save();

        return redirect()->route('admin.categories');  // または、->back()
    }

    public function update(Request $request, $id){
        $request->validate([
            'categ_name'.$id => 'required|max:50|unique:categories,name,'.$id
        ],[
            'categ_name'.$id.'.reuired' => 'Name cannot be blank',
            'categ_name'.$id.'.max' => 'Name must be up to 50 characters only',
            'categ_name'.$id.'.unique' => 'Name must be unique'
            // name of the input.rule name.
        ]);

        $category_a = $this->category->findOrFail($id);

        $category_a->name = $request->input('categ_name'.$id);
        $category_a->save();

        return redirect()->back();
    }


    public function destroy($id){
        // $category_a = $this->category->findOrFail($id);
        // $category_a->forceDelete();  // destroy($id)でok. Admin Categoriesではsoft delete使ってないから。

        $this->category->destroy($id);

        return redirect()->back();
    }


}
