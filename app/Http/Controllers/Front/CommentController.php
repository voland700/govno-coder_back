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
            $comment = Comment::find($request->commentId);

            //$isRegistered = $user->isRegisteredAsLoveReacter();
            //$isRegistered = $comment->isRegisteredAsLoveReactant();

           //$reactionType =  ReactionType::fromName('Like');
            $reacter = $user->getLoveReacter();
            $reactant = $comment->getLoveReactant();
            //$comment = $reacter->reactTo($reactant, $reactionType);



            //$reacterFacade = $user->viaLoveReacter();
            //$reacterFacade->reactTo($comment, 'Like');



            $isReacted = $reactant->isReactedBy($reacter); // if - реагировал





        }




        return $isReacted;



    }

}
