@extends('adminlte::page')

@section('title', 'Публикация новости')

@section('content_header')
    <h1>Публикация новости</h1>
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



    <form role="form" method="post" id="form" action="{{ route('news.store') }}" enctype="multipart/form-data">
        @csrf

        <x-adminlte-card title="Нанные новости" class="col-lg-9" body-class="pb-3" collapsible removable maximizable>
            <div class="row">
                <x-adminlte-input-switch name="active" data-on-color="success" data-off-color="danger" checked/>
                <x-adminlte-input name="title" label="Заголовок статьи" placeholder="Заголовок статьи" fgroup-class="col-12" enable-old-support>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">Обязательно для заполнения</span>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="slug" label="URL - slug" placeholder="slug"  fgroup-class="col-12" enable-old-support/>



                <x-adminlte-input-file name="image" label="Изображение" fgroup-class="col-3 mt-3 mb-3" placeholder="Choose a file..." disable-feedback/>
                <div class="col-12"></div>
                <x-adminlte-input name="link" label="Ссылка на новость" fgroup-class="col-12" placeholder="https://site.com..." enable-old-support/>

                <x-adminlte-textarea name="preview" label="Краткое описание" rows=3 fgroup-class="col-12 mt-3" placeholder="Insert description..."/>
                @php
                    $config = [
                        "height" => "400",
                        "toolbar" => [
                            // [groupName, [list of button]]
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                        ],
                    ]
                @endphp
                <x-adminlte-text-editor name="description" label="Описание" igroup-size="sm" fgroup-class="col-12" placeholder="Write some text..." :config="$config"/>
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
