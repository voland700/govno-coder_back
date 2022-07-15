@extends('front.layouts.layout')
@section('meta-title', 'Облако тегов, список тего для поиска статей')
@section('meta-description', 'Облако тегов - теги поиска статей и материалов на сайте')
@section('meta-keywords')

@section('content')
    <h1 class="tags_title">Облако тегов - вопросы вебразработки</h1>
    <ul class="tags_cloud">
        @foreach($tags as $tag)
            @if($tag->Quantity)
            <li class="tag_item" style="font-size: {{tagSize($tag->Quantity)}}px;"><a href="{{route('tag', $tag->slug)}}" class="tag">{{$tag->name}}</a></li>
            @else
            <li class="tag_item" style="font-size: 20px;"><span class="tag">{{$tag->name}}</span></li>
            @endif
        @endforeach
    </ul>
@endsection
