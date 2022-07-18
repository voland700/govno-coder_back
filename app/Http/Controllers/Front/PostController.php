<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $category = false;
        $posts = Post::with('categories:id,name,slug')->where('active', 1)->paginate(12);
        return view('front.post.posts', compact('category', 'posts'));
    }

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

        $comments = Comment::withDepth()->with('user:id,name')->with([
                'loveReactant.reactions.reacter.reacterable',
                'loveReactant.reactions.type',
                'loveReactant.reactionCounters',
                'loveReactant.reactionTotal',
            ])->where([['post_id', $post->id], ['active', 1]])->paginate(10);
        $comments->setCollection($comments->getCollection()->toTree());

        return view('front.post.post', compact('post', 'categories', 'tags', 'comments'));

        //$comments = Comment::where('post_id', $post->id)->get()->toTree()->paginate(10);
    }

    public function search(Request $request)
    {
        $s = $request->s;
        $request->validate([
            's' => 'required',
        ]);

        $posts = Post::like($request->s)->with('categories:id,name,slug')->where('active', 1)->paginate(12);
        $category = collect([]);
        $category->name =  'Поиск по запросу: '.$s;
        $category->subtitle = null;
        return view('front.post.posts', compact('category', 'posts'));
    }




}
