<div class="comment_item">
    @if($childComment->depth == 1)<div class="gap_1"></div>@endif
    @if($childComment->depth > 1)<div class="gap_2"></div>@endif
    <div class="comment_img{{ Auth::id() == $childComment->user->id ? ' user' : null}}">
        <svg class="coment_user">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use>
        </svg>
    </div>
    <div class="comment_content">
        <h5 class="comment_user">{{$childComment->user->name}}</h5>
        <div class="comment_text">
            {{$childComment->massage}}
            <div class="overflow_wrap"><span class="btn_show">показать</span></div>
        </div>
        <div class="commen_info">
            <span class="comment_time">{{$childComment->getCommentDate()}}</span>
            <span class="comment_answer" data-id="{{$childComment->id}}">Ответить</span>
            <span class="comment_btn_wrap">

             @guest
                    <span class="btn_like_block">
                        <a href="javascript:void(0);" class="btn_like_link unavailable">
                            <span class="icon-thumbs-down"></span>
                        </a>
                        <span class="like_count">4</span>
                    </span>
                    <span class="btn_like_block">
                        <a href="javascript:void(0);" class="btn_like_link unavailable">
                            <span class="icon-heart"></span>
                        </a>
                        <span class="like_count">12</span>
                    </span>
                @endguest
                @auth
                    <span class="btn_like_block">
                        <a href="{{route('comment.reaction')}}" class="btn_like_link available" data-commit_id="{{$childComment->id}}" data-type="Dislike">
                            <span class="icon-thumbs-down"></span>
                        </a>
                        <span class="like_count">4</span>
                    </span>
                    <span class="btn_like_block">
                        <a href="{{route('comment.reaction')}}" class="btn_like_link available" data-commit_id="{{$childComment->id}}" data-type="Like">
                            <span class="icon-heart"></span>
                        </a>
                        <span class="like_count">12</span>
                    </span>
                @endauth
            </span>
        </div>
    </div>
</div>
@if(count($childComment->children)>0)
    @foreach ($childComment->children as $childComment)
        @include('front.layouts.child_comment', ['childComment' => $childComment])
    @endforeach
@endif
