<span class="btn_like_block {{$comment->user_reaction == 'dislike' ? 'dislike' : null }}">
     @if($comment->user_reaction == 'dislike')
     <a class="btn_dislike_link">
     @else
     <a href="{{route('comment.reaction')}}" class="btn_dislike_link available" data-commit_id="{{$comment->id}}" data-type="Dislike">
    @endif
        <span class="icon-thumbs-down"></span>
    </a>
    <span class="like_count-dislike">{{$comment->getDislikeCount()}}</span>
</span>
<span class="btn_like_block {{$comment->user_reaction == 'like' ? 'like' : null }}">
    @if($comment->user_reaction == 'like')
    <a  class="btn_like_link">
    @else
    <a href="{{route('comment.reaction')}}" class="btn_like_link available" data-commit_id="{{$comment->id}}" data-type="Like">
    @endif
        <span class="icon-heart"></span>
    </a>
    <span class="like_count-like">{{$comment->getLikeCount()}}</span>
</span>
