<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function list($slug = null)
    {
        if($slug){
            $category = Category::where('active', 1)->first();
            $posts = $category->posts()->with('categories:id,name,slug')->where('active', 1)->paginate(12);
            return view('front.post.posts', compact('category', 'posts'));

            //dd($posts);
        }







    }
}
