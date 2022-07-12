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
            $comment = Comment::create([
                'post_id'   => $request->post_id,
                'parent_id' => $request->parent_id,
                'user_id'   => $request->user()->id,
                'massage'   => $request->massage
            ]);
            $comment::fixTree();
        }
        return back()->withInput();
    }


    public function reaction(Request $request)
    {
        if(Auth::check() ){
            $user = Auth::user();
            $comment = Comment::with([
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
            $comment = Comment::with([
                'loveReactant.reactions.reacter.reacterable',
                'loveReactant.reactions.type',
                'loveReactant.reactionCounters',
                'loveReactant.reactionTotal',
            ])->find($request->commentId);
            $view = view('front.layouts.comment_ajax', compact('comment'))->render();
            return ['status' => 200, 'view' => $view];
        }
    }
}
