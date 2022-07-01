<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        if($request->massage && Auth::check() ){
            //$post = Post::where('id', $request->post_id)->select('id', 'slug')->first();

            Comment::create([
                'post_id'   => $request->post_id,
                'parent_id' => $request->parent_id,
                'user_id'   => $request->user()->id,
                'massage'   => $request->massage
            ]);

            //dd($request->all());

        }
        return back()->withInput();



        //dd($request->all());
        //dd(Auth::id());
        //return 'OK';

    }
}
