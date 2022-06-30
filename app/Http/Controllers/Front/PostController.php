<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function list(Request $request)
    {
        $category = Category::where([['active', 1], ['slug', $request->slug]])->first();
        $posts = $category->posts()->with('categories:id,name,slug')->where('active', 1)->paginate(12);
        return view('front.post.posts', compact('category', 'posts'));
    }

    public  function item(Request $request)
    {
        $post = Post::where('slug', $request->slug)->first();
        $categories = $post->categories()->where(function (Builder $query) {
            return $query->where('active', 1)->select('id', 'name', 'slug');
        })->get();
        $tags = $post->tags()->where(function (Builder $query) {
            return $query->where('active', 1)->select('id', 'name', 'slug');
        })->get();

        return view('front.post.post', compact('post', 'categories', 'tags'));








    }




}
