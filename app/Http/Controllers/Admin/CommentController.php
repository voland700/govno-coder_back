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
        ])->orderBy('id', 'ASC')->paginate(10);
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
        $comment = Comment::with([
            'loveReactant.reactions.reacter.reacterable',
            'loveReactant.reactions.type',
            'loveReactant.reactionCounters',
            'loveReactant.reactionTotal',
        ])->where('id', $id)->with('user:id,name')->first();
        $post = Post::where('id', $comment->post_id)->select('id', 'name')->first();
        return view('admin.comment.edit', compact('comment', 'post'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $comment->update($data);
        $comment::fixTree();
        return redirect()->route('admin.comments')->with('success', 'Коментарий успешно изменен');

    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        $comment::fixTree();
        return redirect()->route('admin.comments')->with('success', 'Коментарий успешно удалён');
    }

}
