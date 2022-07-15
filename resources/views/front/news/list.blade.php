@extends('front.layouts.layout')
@section('meta-title', 'Новости IT, програмирования, информационной безопасности и омпьютерных техноогий')
@section('meta-description', 'Последние новости из мира компьютерных технолоий и информационой безопасновсти, обзор новостей и новых подхдов в програмировании и изменений законодательства данной области')
@section('meta-keywords', 'новости, компьютеры, it, програмирование, безопасность, информация, обзор, популярное, интересное, новинки, офоициальный, сайт')

@section('h1', 'Последние новости из мира компьютерных технологий и информационной безопасности')

@section('content')

    <div class="main_title_wrap">
        <h1 class="main_title">Новости</h1>
        <p class="main_subtitle">Последние новости из мира компьютерных технологий и информационной безопасности</p>
    </div>
    <div class="main_list_wrap">
        @foreach($news as $new)
            <div class="main_item_wrap">
                <div class="news_item_img_wrap">

                    <a href="{{route('new', $new->slug)}}" class="news_item_img_link">
                        @if($new->image)
                            <img src="{{asset($new->image)}}" alt="{{$new->name}}" class="news_item_img">
                        @else
                            <img src="{{asset('images/src/no-photo/nope.jpg')}}" alt="нет фото" class="news_item_img">
                        @endif
                    </a>
                </div>
                <div class="main_item_body">
                    <h3 class="news_item_name_h3">
                        <a href="{{route('new', $new->slug)}}" class="main_item_link">{{$new->title}}</a>
                    </h3>
                    <p class="new_item_txt">{{$new->preview}}</p>
                    <div class="main_item_time_wrap">
                        <time class="main_item_time" datetime="2001-05-15">{{ $new->getNewsDate() }}</time>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $news->links('front.layouts.pagination')}}
@endsection
