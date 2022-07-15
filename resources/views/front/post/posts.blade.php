@extends('front.layouts.layout')
@section('meta-title', 'Везувий Легенда - отопительные и банные печи Везувий, грили, мангалы и барбекю. Официальный сайт представителя Везувий в Москве')
@section('meta-description', 'Печи для бани, отопительные печи для дома и дачи, садовые и уличные печи -очаги: гриль, мангалы и барбекю. Каталог товаров Везувий в Москве')
@section('meta-keywords', 'печи, камины, дымоходы, банные, бани, чугунные, дровяные, литье, для печей, купить, цена, офоициальный, сайт, везувий')

@section('h1', 'Официальный сайт представителя Везувий в Москве')

@section('content')

    @if($category)
    <div class="main_title_wrap">
        <h1 class="main_title">{{$category->name}}</h1>
        @if($category->subtitle)
        <p class="main_subtitle">{{$category->subtitle}}</p>
        @endif
    </div>
    @else
        <div class="main_title_wrap">
            <h1 class="main_title">Программирование и веб-разработка</h1>
            <p class="main_subtitle">Подборка статей, обзоров и рекомендации по программированию и веб-разработке</p>
        </div>
    @endif
    <div class="main_list_wrap">
        @foreach($posts as $post)
            <div class="main_item_wrap">
                <div class="main_item_img_wrap">
                    <a href="{{route('post', $post->slug)}}" class="main_item_img_link">
                        @if($post->preview)
                            <img src="{{$post->preview['full']}}" srcset="{{$post->preview['tiny']}} 1200w, {{$post->preview['small']}} 767w, {{$post->preview['middle']}} 767w, {{$post->preview['small']}} 525w, {{$post->preview['tiny']}} 415w"  alt="{{$post->name}}" class="main_item_img">
                        @else
                            <img src="{{asset('images/src/no-photo/full.jpg')}}" srcset="{{asset('images/src/no-photo/tiny.jpg')}} 1200w, {{asset('images/src/no-photo/small.jpg')}} 767w, {{asset('images/src/no-photo/middle.jpg')}} 767w, {{asset('images/src/no-photo/small.jpg')}} 525w, {{asset('images/src/no-photo/tiny.jpg')}} 415w"  alt="{{$post->name}}" class="main_item_img">
                        @endif
                    </a>
                </div>
                <div class="main_item_body">
                    <div class="main_item_category_wrap">
                        @foreach($post->categories as $category)
                            <a href="{{route('posts', $category->slug)}}" class="main_item_category">{{$category->name}}@if(!$loop->last),@endif</a>
                        @endforeach
                    </div>
                    <h3 class="main_item_name_h3">
                        <a href="{{route('post', $post->slug)}}" class="main_item_link">{{$post->name}}</a>
                    </h3>
                    <p class="main_item_txt">{{$post->short}}</p>
                    <div class="main_item_time_wrap">
                        <time class="main_item_time" datetime="2001-05-15">{{ $post->getPostDate() }}</time>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $posts->links('front.layouts.pagination')}}
@endsection
