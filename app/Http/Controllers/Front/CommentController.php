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
            Comment::create([
                'post_id'   => $request->post_id,
                'parent_id' => $request->parent_id,
                'user_id'   => $request->user()->id,
                'massage'   => $request->massage
            ]);
        }
        return back()->withInput();
    }


    public function reaction(Request $request)
    {
        if(Auth::check() ){
            $user = Auth::user();
            $comment = Comment::with('user:id,name')->with([
                'loveReactant.reactions.reacter.reacterable',
                'loveReactant.reactions.type',
                'loveReactant.reactionCounters',
                'loveReactant.reactionTotal',
            ])->find($request->commentId);

            $reacterFacade = $user->viaLoveReacter();
            if($reacterFacade->hasReactedTo($comment)){
                if($reacterFacade->hasReactedTo($comment, 'Like')) return false;
                if($reacterFacade->hasReactedTo($comment, 'Dislike')) return false;
            }
            $reacterFacade->reactTo($comment, $request->type);
            $comment = Comment::with('user:id,name')->with([
                'loveReactant.reactions.reacter.reacterable',
                'loveReactant.reactions.type',
                'loveReactant.reactionCounters',
                'loveReactant.reactionTotal',
            ])->find($request->commentId);
            return view('front.layouts.comment_ajax', compact('comment'));
        }


    }


    public function test()
    {
        $comment = Comment::where('id', 3)->with('user:id,name')->with([
            'loveReactant.reactions.reacter.reacterable',
            'loveReactant.reactions.type',
            'loveReactant.reactionCounters',
            'loveReactant.reactionTotal',
        ])->first();
        //$user = Auth::user();
       dd($comment->user_reaction);
        //dd($user->name);

    }


















}
