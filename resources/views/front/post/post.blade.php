@extends('front.layouts.layout')
@section('meta-title')
@section('meta-description')
@section('meta-keywords')



@section('content')
    <h1 class="page_title">{{$post->named}}</h1>
    <time class="page_date">{{ $post->getPostDate() }}</time>

    <main class="page_wrap">
        <div class="page_img_wrup">
            @if($post->getMedia('main')->isNotEmpty())
                <img src="{{$post->preview['full']}}" srcset="{{$post->preview['full']}} 1200w, {{$post->preview['middle']}} 690w, {{$post->preview['small']}} 494w, {{$post->preview['tiny']}} 385w"  alt="{{$post->name}}" class="page_img">
            @endif
        </div>
        <div class="page_content">
            {!! $post->description !!}
            <div class="page_info_wrap">
                @if($post->author)
                    @if($post->link)
                        <p class="page_autor">Автор: <a href="{{$post->link}}" class="page_autor_link">{{$post->author}}</a></p>
                    @else
                        <p class="page_autor">Автор: <span class="page_autor_link">{{$post->author}}</span></p>
                    @endif
                @endif
                @if($post->translator)
                        <p class="page_autor">Перевод:<span class="page_autor__span">{{$post->translator}}</span></p>
                @endif
                <div class="page_info_block">
                    <div class="page_info_item">
                        <h3 class="page_info_title">Категории</h3>
                        @foreach($categories as $category)
                            <a href="{{route('posts', $category->slug)}}" class="page_category">{{$category->name}}@if(!$loop->last),@endif</a>
                        @endforeach
                    </div>

                    <div class="page_info_item">
                        <h3 class="page_info_title">Теги</h3>
                        @foreach($tags as $tag)
                            <a href="{{route('tag', $tag->slug)}}" class="page_tag">{{$tag->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> <!-- Wrapper page content -->
    </main>



    <!-- COMMENTS -->
    <section class="comments_block">
        <h3 class="comments_title">Комментарии</h3>
        <div class="comments_list">




        </div><!-- WRAPPER -->

        <div class="comment_form_wrap">
            <div class="comment_img{{ Auth::check() ? ' user' : null}}">
                <svg class="coment_user">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use>
                </svg>
            </div>

            <div class="comment_form_block">
                <h5 class="comment_user">{{ Auth::check() ? Auth::user()->name : 'Гость'}} </h5>
                <form action="#" method="POST" id="commentForm" class="comment_form">

                    <input type="hidden" name="post_id" value="7">
                    <input type="hidden" id="parentId" name="paren_id" value="0">
                    <textarea name="comment" id="comment" class="comment_form_fild" cols="30" rows="10"></textarea>
                    @if(Auth::check())
                        <input type="submit" class="comment_btn" value="Отправить">
                    @endif
                </form>
                @guest
                    <span class="comment_btn">Регистрация</span>
                    <span class="comment_btn">Войти</span>
                @endguest
            </div>
        </div><!-- FORM -->





    </section>
@endsection



@section('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', (event) => {

            let fancybox;

            async function postData(url = '', data = {}) {
                // Default options are marked with *
                const response = await fetch(url, {
                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    mode: 'cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    credentials: 'same-origin', // include, *same-origin, omit
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Content-Type': 'application/json'
                        // 'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    redirect: 'follow', // manual, *follow, error
                    referrerPolicy: 'no-referrer', // no-referrer, *client
                    body: JSON.stringify(data) // body data type must match "Content-Type" header
                });
                //return await response.text(); // parses Text response into native JavaScript objects
                //return await response.json(); // parses JSON response into native JavaScript objects
                console.log(response.status);
                return await response.text();
            }



            function getLogIn(){
                fetch('{{ route('user.auth') }}')
                    .then((response) => {
                        return response.text();
                    })
                    .then((data) => {
                        fancybox = Fancybox.show([{ src: data, type: "html" }]);
                        sendLogin();
                    });
            }

            function sendLogin(){
                let valid =null;

                const loginForm = document.getElementById('loginForm');
                document.getElementById('formBtn').addEventListener('click', function (event) {
                    event.preventDefault();
                    let formData = {
                        'email': loginForm.querySelector('[name="email"]').value,
                        'password': loginForm.querySelector('[name="password"]').value,
                    }
                    if(loginForm.querySelector('[name="remember"]').checked)  formData.remember = true;
                    //console.log(formData);


                    fetch('{{route('user.auth.store')}}', {
                        method: 'POST', // or 'PUT'
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)

                    })
                        .then(function (response){
                            if(response.status == 422) valid = false;
                            if(response.status == 200) valid = true;
                            console.log(valid);
                            return response;
                        }).then( response => response.text())
                        .then(data => {
                            if(valid){
                                document.querySelector('.fancybox__content').innerHTML =  data;
                                setTimeout(() => fancybox.close(), 3000);
                                //console.log(data);
                            }
                            if(!valid){
                                document.querySelector('.fancybox__content').innerHTML = data;
                                //console.log(data);
                            }
                        }).catch((error) => {
                        //document.querySelector('.fancybox__content').innerHTML = data;
                        console.log(error);
                    });
                });
            }





















            function getRegister(){


                fetch('{{ route('user.register') }}')
                    .then((response) => {
                        return response.text();
                    })
                    .then((data) => {
                        fancybox = Fancybox.show([{ src: data, type: "html" }]);
                        sendRegister();
                    });

                function sendRegister(){
                    const registerForm  = document.getElementById('registerForm');

                    document.getElementById('formBtn').addEventListener('click', function (event){
                        event.preventDefault();
                        let formData = {
                            'name': registerForm.querySelector('[name="name"]').value,
                            'email': registerForm.querySelector('[name="email"]').value,
                            'password': registerForm.querySelector('[name="password"]').value,
                            'password_confirmation': registerForm.querySelector('[name="password_confirmation"]').value
                        }
                        let valid = null;

                        fetch('{{route('user.store')}}', {
                            method: 'POST', // or 'PUT'
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(formData)

                        })
                            .then(function (response){
                                if(response.status == 400) valid = false;
                                if(response.status == 200) valid = true;
                                //console.log(valid);
                                return response;
                            }).then( response => response.text())
                            .then(data => {
                                if(valid){
                                    document.querySelector('.fancybox__content').innerHTML = data;
                                    setTimeout(() => fancybox.close(), 3000);
                                    //console.log(data);
                                }
                                if(!valid){
                                    document.querySelector('.fancybox__content').innerHTML = data;
                                    //console.log(data);
                                }
                            }).catch((error) => {
                            //document.querySelector('.fancybox__content').innerHTML = data;
                            console.log(error);
                        });
                    });
                };
            }







            document.getElementById('authBtn').addEventListener('click', function (event){
                event.preventDefault();
                getLogIn();
            });

            document.getElementById('registerBtn').addEventListener('click', function (event){
                event.preventDefault();
                getRegister();
            });





        });// --- DOM LOUDER


    </script>
@endsection
