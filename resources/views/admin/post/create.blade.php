@extends('adminlte::page')

@section('title', 'Новая статья')

@section('content_header')
    <h1>Новая статья</h1>
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



    <form role="form" method="post" id="form" action="{{ route('post.store') }}">
        @csrf

        <x-adminlte-card title="Новая статья" class="col-lg-9" body-class="pb-3" collapsible removable maximizable>
            <div class="row">


                <x-adminlte-input-switch name="active" data-on-color="success" data-off-color="danger" checked/>

                <x-adminlte-input name="name" label="Название статьи" placeholder="Название статьи" fgroup-class="col-12" enable-old-support>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">Обязательно для заполнения</span>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="slug" label="URL - slug" placeholder="slug"  fgroup-class="col-12" enable-old-support/>
                @php
                    $selected = [];
                @endphp
                <x-adminlte-select id="category" name="category[]" label="Рубрики" fgroup-class="col-lg-6" multiple>
                    <x-adminlte-options :options="$categories" :selected="$selected"/>
                </x-adminlte-select>
                @php
                    $config = [
                        "placeholder" => "Выберете тег",
                        "allowClear" => true,
                    ];
                @endphp
                <x-adminlte-select2 id="sel2Category" name="tags[]" label="Теги" fgroup-class="col-lg-6" igroup-size="sm" :config="$config" multiple>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </x-adminlte-select2>
                <h4 class="col-lg-9 mt-3 mb-2">СЕО данные статьи</h4>
                <x-adminlte-input name="meta_title" label="META - title" placeholder="slug"  fgroup-class="col-12" enable-old-support/>
                <x-adminlte-input name="meta_keywords" label="META - keywords" fgroup-class="col-12" enable-old-support/>
                <x-adminlte-textarea name="meta_description" label="META - description" fgroup-class="col-12" placeholder="Insert description..." enable-old-support/>

                <h4 class="col-lg-9 mt-3 mb-2">Контент статьи</h4>
                <x-adminlte-input name="title" label="Заголовок для статьи" fgroup-class="col-12" enable-old-support/>

                <div class="col-12 mt-3 mb-3">
                    <input type="hidden" name="img" id="img" value="">
                    <input type="hidden" name="preview" id="preview" value="">
                    <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="imageDropzone">Основное изображение</label>
                        <div class="dropzone" id="imageDropzone"></div>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="thumbnailDropzone">Изображение анонса</label>
                        <div class="dropzone" id="thumbnailDropzone"></div>
                    </div>
                    </div>
                </div>


                <x-adminlte-input name="author" label="Автор статьи" fgroup-class="col-6" placeholder="Astrid Lindgren" enable-old-support/>
                <x-adminlte-input name="link" label="Ссылка на статью" fgroup-class="col-6" placeholder="https://site.com..." enable-old-support/>
                <x-adminlte-input name="translator" label="Автор перевода" fgroup-class="col-6" placeholder="Василий Теркин" enable-old-support/>

                <x-adminlte-textarea name="summary" label="Краткое описание" rows=3 fgroup-class="col-12 mt-3" placeholder="Insert description..."/>

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

    <link rel="stylesheet" href="/assets/admin/plugins/dropzone/dropzone.min.css">
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop


@section('js')
    <script src="/assets/admin/plugins/dropzone/dropzone.min.js"></script>
    <script>
        const form = document.getElementById('form');
        const img = document.getElementById('img');
        const preview = document.getElementById('preview');

        Dropzone.autoDiscover = false;
        let myDropzone = new Dropzone("#imageDropzone", {
            url: '{{route('dropzone.upload')}}',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
            method: 'POST',
            maxFilesize: 2,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 60000,
            params: {
                type: 'img'
            },
            removedfile: function(file){
                file.previewElement.remove();
                if(!img.value == null || !img.value == ''){
                    RemoveTmpFile(img.value);
                }
                img.value=null;
            },
            success: function (file, response) {
                img.value = response.path;
                //console.log(response.success);
            },
            error: function (file, response) {
                console.log(response);
                //return false;
            }
        });

        let thumbnailDropzone = new Dropzone("#thumbnailDropzone", {
            url: '{{route('dropzone.upload')}}',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
            method: 'POST',
            maxFilesize: 2,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 60000,
            params: {
                type: 'preview'
            },
            removedfile: function(file){
                file.previewElement.remove();
                if(!preview.value == null || !preview.value == ''){
                    RemoveTmpFile(preview.value);
                }
                preview.value=null;
            },
            success: function (file, response) {
                preview.value = response.path;
            },
            error: function (file, response) {
                console.log(response);
            }
        });

        function RemoveTmpFile(name){
            $.ajax(
                {
                    url: '{{route('dropzone.tnp.remove')}}',
                    type: 'POST',
                    data: {
                        _token: document.querySelector('meta[name=csrf-token]').content,
                        path: name,
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
        }
    </script>
@stop
