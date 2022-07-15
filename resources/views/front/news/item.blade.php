@extends('front.layouts.layout')
@section('meta-title', $new->title)
@section('meta-description', $new->preview)
@section('meta-keywords')



@section('content')
    <h1 class="page_title">{{$new->title}}</h1>
    <time class="page_date">{{ $new->getNewsDate() }}</time>

    <main class="page_wrap">
        @if($new->image)
        <div class="page_img_wrup">
            <img src="{{$new->image}}" alt="{{$new->title}}" class="page_img">
        </div>
        @endif
        <div class="page_content">
            @if($new->preview)<p>{{$new->preview}}</p>@endif
            {!! $new->description !!}

            <div class="social_sharing">
                <div class="ya-share2" data-curtain data-services="vkontakte,telegram,messenger,twitter,viber,whatsapp"></div>
            </div>
        </div> <!-- Wrapper page content -->
    </main>

    @if($theLast->isNotEmpty())

    <div class="news_list_wrap">
        @foreach($theLast as $item)
        <div class="news_item_wrap">
            <div class="news_item_img_wrap">
                <a href="{{route('new', $new->slug)}}" class="news_item_img_link">
                    @if($item->image)
                        <img src="{{asset($item->image)}}" alt="{{$item->name}}" class="news_item_img">
                    @else
                        <img src="{{asset('images/src/no-photo/nope.jpg')}}" alt="нет фото" class="news_item_img">
                    @endif
                </a>
            </div>
            <div class="main_item_body">
                <h3 class="news_item_name_h3">
                    <a href="{{route('new', $item->slug)}}" class="main_item_link">{{$item->title}}</a>
                </h3>
                <p class="new_item_txt">{{$item->preview}}</p>
                <div class="main_item_time_wrap">
                    <time class="main_item_time" datetime="{{$item->created_at}}">{{ $item->getNewsDate() }}</time>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
@endsection

@section('scripts')
    <script src="https://yastatic.net/share2/share.js"></script>
@endsection
