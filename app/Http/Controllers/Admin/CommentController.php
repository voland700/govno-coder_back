<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with([
            'user:id,name',
            'post:id,name'
        ])->orderBy('created_at', 'ASC')->paginate(10);
        return view('admin.comment.index', compact('comments'));
    }

    public function commentsTree($id)
    {
        $post = Post::select('id', 'name')->first($id);
        $comments = Comment::withDepth()->with('user:id,name')->where('post_id', $id)->paginate(10);
        $comments->setCollection($comments->getCollection()->toTree());

        return view('admin.comment.tree', compact('comments', 'post'));
    }

    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }



}
