@extends('adminlte::page')

@section('title', 'Редактирование статьи')

@section('content_header')
    <h1>Редактирование статьи</h1>
@stop

@section('content')

    @if (count($errors) > 0)
        <x-adminlte-alert theme="danger" class="col-lg-9"  dismissable>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif
    <form role="form" method="post" id="form" action="{{  route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')



        <x-adminlte-card title="Данные статьи" class="col-lg-9" body-class="pb-3" collapsible removable maximizable>
            <div class="row">
                @php
                $configSwitch = [
                    'state' => $post->active == 1 ? true : false
                ];
                @endphp

                <x-adminlte-input-switch name="active" data-on-color="success" data-off-color="danger" :config="$configSwitch" />


                <x-adminlte-input name="name" label="Название статьи" value="{{$post->name}}" fgroup-class="col-12" enable-old-support>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">Обязательно для заполнения</span>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="slug" label="URL - slug" value="{{$post->slug}}"  fgroup-class="col-12" enable-old-support/>

                <x-adminlte-select id="categories" name="categories[]" label="Рубрики" fgroup-class="col-lg-6" multiple>
                    <x-adminlte-options :options="$categories" :selected="$selectedCategories"/>
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
                        <option value="{{$tag->id}}" {{in_array($tag->id, $selectedTags) ? 'selected' : ''}}>{{$tag->name}}</option>
                    @endforeach
                </x-adminlte-select2>
                <h4 class="col-lg-9 mt-3 mb-2">СЕО данные статьи</h4>
                <x-adminlte-input name="meta_title" label="META - title" fgroup-class="col-12" value="{{$post->meta_title}}" enable-old-support/>
                <x-adminlte-input name="meta_keywords" label="META - keywords" fgroup-class="col-12" value="{{$post->meta_keywords}}" enable-old-support/>
                <x-adminlte-textarea name="meta_description" label="META - description" fgroup-class="col-12" enable-old-support>{{$post->meta_description}}</x-adminlte-textarea>
                <h4 class="col-lg-9 mt-3 mb-2">Контент статьи</h4>
                <x-adminlte-input name="title" label="Заголовок для статьи" fgroup-class="col-12" value="{{$post->title}}" enable-old-support/>




                <div class="form-group col-4 mt-3 mb-3">
                    <div class="post_img_upload" id="imgWrap">
                        @if($img['url'])
                        <div class="post_img_wrap mb-3">
                            <img src="{{$img['url']}}" alt="Изображение" id="imgPost" class="post_img">
                        </div>
                        <div class="post_btn_img_delete" id="imgDelete" onclick="imageRemove()"><i class="fas fa-times"></i></div>
                        @else
                            <div class="post_img_wrap mb-3">
                                <img src="{{asset('/assets/admin/img/no-photo.jpg')}}" alt="Нет фото" class="post_img">
                            </div>
                        @endif
                    </div>
                    <label for="image">Изображение</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" id="image" name="file" class="custom-file-input">
                            <label class="custom-file-label text-truncate" for="image" id="imgNameFile"> @if($img['name']) {{$img['name']}} @else Choose a file... @endif</label>
                        </div>
                    </div>
                    <span class="post_img_error_message" id="errorMessage"></span>
                </div>





                <div class="col-12"></div>
                <x-adminlte-input name="author" label="Автор статьи" fgroup-class="col-6" value="{{$post->author}}" enable-old-support/>
                <x-adminlte-input name="link" label="Ссылка на статью" fgroup-class="col-6" value="{{$post->link}}" enable-old-support/>
                <x-adminlte-input name="translator" label="Автор перевода" fgroup-class="col-6" value="{{$post->translator}}" enable-old-support/>
                <x-adminlte-textarea name="summary" label="Краткое описание" rows=3 fgroup-class="col-12 mt-3">{!! $post->summary !!}</x-adminlte-textarea>
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
                <x-adminlte-text-editor name="description" label="Описание" igroup-size="sm" fgroup-class="col-12" placeholder="Write some text..." :config="$config">{!! $post->description !!}</x-adminlte-text-editor>
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
    <script>
        const imgWrap = document.getElementById('imgWrap');
        const imgNameFile = document.getElementById('imgNameFile');
        const errorMessage = document.getElementById('errorMessage');

        async function getImage(url = '', data = {}) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin', // include, *same-origin, omit
                headers: {
                    'Content-Type': 'application/json'
                },
                redirect: 'follow', // manual, *follow, error
                referrerPolicy: 'no-referrer', // no-referrer, *client
                body: JSON.stringify(data) // body data type must match "Content-Type" header
            });
            return await response.text(); // parses JSON response into native JavaScript objects
        }

        function imageRemove(){
            getImage('{{route('remove.img')}}', {
                _token: document.querySelector('meta[name=csrf-token]').content,
                id: {{$post->id}}
            }) .then((data) => {
                document.getElementById('imgPost').src = '/assets/admin/img/no-photo.jpg';
                document.getElementById('imgDelete').remove();
                imgNameFile.innerText = 'Choose a file...';
                errorMessage.innerText = '';
                if(errorMessage.classList.contains('active')) errorMessage.classList.remove('active');
            });
        }

        const inputElement = document.getElementById("image");
        inputElement.addEventListener("change", handleFiles, false);

        function handleFiles() {
            let file = this.files[0]; /* now you can work with the file list */
            let formData = new FormData();
            formData.append("file", file, file.name);
            formData.append("_token", document.querySelector('meta[name=csrf-token]').content );
            formData.append("id", {{$post->id}} );

            async function uploadFile(url = '', data = {}) {
                // Default options are marked with *
                const response = await fetch(url, {
                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    mode: 'cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    credentials: 'same-origin', // include, *same-origin, omit
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        //'Content-Type': 'multipart/form-data',
                        //'Content-Type': 'application/json'
                        // 'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    redirect: 'follow', // manual, *follow, error
                    referrerPolicy: 'no-referrer', // no-referrer, *client
                    body: data // body data type must match "Content-Type" header
                });
                return await response.json(); // parses JSON response into native JavaScript objects
            }

            uploadFile('{{route('update.img')}}', formData)
                .then((data) => {
                    if(!data.error){
                        imgWrap.innerHTML = data.template;
                        imgNameFile.innerText = data.fileName;
                        errorMessage.innerText = '';
                        if(errorMessage.classList.contains('active')) errorMessage.classList.remove('active');
                    } else {
                        errorMessage.innerText = data.errorMessage;
                        if(!errorMessage.classList.contains('active')) errorMessage.classList.add('active');
                    }
                    //console.log(data);
                });
        }
    </script>

@stop
