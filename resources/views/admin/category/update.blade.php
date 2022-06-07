@extends('adminlte::page')

@section('title', 'Создание новой категории')

@section('content_header')
    <h1>Страница редактирования рубрики</h1>
@stop

@section('content')

    @if (count($errors) > 0)
        <x-adminlte-alert theme="danger" class="col-lg-6"  dismissable>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif



    <form role="form" method="post" action="{{  route('category.update', $category->id) }}">
            @csrf
            @method('PUT')

        <x-adminlte-card title="Данные рубрики" class="col-lg-6" body-class="pb-3" collapsible removable maximizable>

            <x-adminlte-input-switch name="active" data-on-color="success" data-off-color="danger" {{($category->active == 1) ? 'checked' : ''}}/>

            <div class="form-group row">
                <div class="col-sm-2">
                    <input type="number" class="form-control @error('sort') is-invalid @enderror" id="sort"  name="sort" value="{{$category->sort}}">
                </div>
                <label for="sort" class="col-sm-4 col-form-label">Индекс сортировки</label>
            </div>


            <div class="row">

                <x-adminlte-input name="name" label="Название рубрики" value="{{$category->name}}" fgroup-class="col-12" enable-old-support>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">Обязательно для заполенения</span>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="slug" label="URL - slug" placeholder="slug"  fgroup-class="col-12" value="{{$category->slug}}" enable-old-support/>
                <x-adminlte-input name="title" label="Заголовок рубрики" fgroup-class="col-12" value="{{$category->title}}" enable-old-support/>
                <x-adminlte-input name="subtitle" label="Подзаголовок рубрики" fgroup-class="col-12" value="{{$category->subtitle}}" enable-old-support/>

                <h4 class="col-lg-9 mt-3 mb-2">СЕО данные рубрики</h4>
                <x-adminlte-input name="meta_title" label="META - title" placeholder="slug"  fgroup-class="col-12" value="{{$category->meta_title}}" enable-old-support/>
                <x-adminlte-input name="meta_keywords" label="META - keywords" fgroup-class="col-12" value="{{$category->meta_keywords}}" enable-old-support/>
                <x-adminlte-textarea name="meta_description" label="META - description" fgroup-class="col-12" enable-old-support>{{$category->meta_description}}</x-adminlte-textarea>
            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button label="Обновить" type="submit" class="d-flex ml-auto" theme="primary" />
            </x-slot>
        </x-adminlte-card>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
