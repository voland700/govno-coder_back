<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function list(){
        $tags = Tag::with('posts:id')->where('active', 1)->select('id', 'name', 'slug','active')->get();
        return view('front.tag.list', compact('tags'));

    }

    public function tags(Request $request)
    {
        $tag = Tag::where([['active', 1], ['slug', $request->slug]])->first();
        $posts = $tag->posts()->with('categories:id,name,slug')->where('active', 1)->paginate(12);
        $category = collect([]);
        $category->name = $tag->title ? $tag->title : $tag->name;
        $category->subtitle = $tag->subtitle ?$tag->subtitle : null;
        return view('front.post.posts', compact('category', 'posts'));
    }
}
