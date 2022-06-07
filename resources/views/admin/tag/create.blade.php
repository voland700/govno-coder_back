@extends('adminlte::page')

@section('title', 'Создание нового тега')

@section('content_header')
    <h1>Страница создания нового тега</h1>
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



    <form role="form" method="post" action="{{ route('tag.store') }}">
        @csrf

        <x-adminlte-card title="Новый тег" class="col-lg-6" body-class="pb-3" collapsible removable maximizable>

            <x-adminlte-input-switch name="active" data-on-color="success" data-off-color="danger" checked/>
            <div class="row">

                <x-adminlte-input name="name" label="Название тага" placeholder="Название тега" fgroup-class="col-12" enable-old-support>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">Обязательно для заполенения</span>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="slug" label="URL - slug" placeholder="slug"  fgroup-class="col-12" enable-old-support/>
                <x-adminlte-input name="title" label="Заголовок для тега" fgroup-class="col-12" enable-old-support/>
                <x-adminlte-input name="subtitle" label="Подзаголовок для тега" fgroup-class="col-12" enable-old-support/>

                <h4 class="col-lg-9 mt-3 mb-2">СЕО данные для страницы тага</h4>
                <x-adminlte-input name="meta_title" label="META - title" placeholder="slug"  fgroup-class="col-12" enable-old-support/>
                <x-adminlte-input name="meta_keywords" label="META - keywords" fgroup-class="col-12" enable-old-support/>
                <x-adminlte-textarea name="meta_description" label="META - description" fgroup-class="col-12" placeholder="Insert description..." enable-old-support/>
            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button label="Сохранить" type="submit" class="d-flex ml-auto" theme="primary" />
            </x-slot>
        </x-adminlte-card>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')

@stop
