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
            @if($comments->isNotEmpty())
                @foreach($comments as $comment)

                    <div class="comment_item">
                        <div class="comment_img{{ Auth::id() == $comment->user->id ? ' user' : null}}">
                            <svg class="coment_user">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use>
                            </svg>
                        </div>
                        <div class="comment_content">
                            <h5 class="comment_user">{{$comment->user->name}}</h5>
                            <div class="comment_text">
                                {{$comment->massage}}
                                <div class="overflow_wrap"><span class="btn_show">показать</span></div>
                            </div>
                            <div class="commen_info">
                                <span class="comment_time">{{$comment->getCommentDate()}}</span>
                                <span class="comment_answer" data-id="{{$comment->id}}">Ответить</span>
                                <span class="comment_btn_wrap">
                                @guest
                                    <span class="btn_like_block">
                                        <a href="javascript:void(0);" class="btn_like_link unavailable">
                                            <span class="icon-thumbs-down unavailable"></span>
                                        </a>
                                        <span class="like_count-dislike">{{$comment->getDislikeCount()}}</span>
                                    </span>
                                    <span class="btn_like_block">
                                        <a  href="javascript:void(0);" class="btn_like_link unavailable">
                                            <span class="icon-heart"></span>
                                        </a>
                                        <span class="like_count-like">{{$comment->getLikeCount()}}</span>
                                    </span>
                                @endguest
                                @auth
                                    <span class="btn_like_block {{$comment->user_reaction == 'dislike' ? 'dislike' : null}}">
                                        @if($comment->user_reaction == 'dislike')
                                        <a class="btn_dislike_link">
                                        @else
                                        <a href="{{route('comment.reaction')}}" class="btn_dislike_link available" data-commit_id="{{$comment->id}}" data-type="Dislike">
                                        @endif
                                            <span class="icon-thumbs-down"></span>
                                        </a>
                                        <span class="like_count-dislike">{{$comment->getDislikeCount()}}</span>
                                    </span>
                                    <span class="btn_like_block {{ $comment->user_reaction == 'like' ? 'like' : null }}">
                                        @if($comment->user_reaction == 'like')
                                        <a class="btn_like_link">
                                        @else
                                        <a href="{{route('comment.reaction')}}" class="btn_like_link available" data-commit_id="{{$comment->id}}" data-type="Like">
                                        @endif
                                            <span class="icon-heart"></span>
                                        </a>
                                        <span class="like_count-like">{{$comment->getLikeCount()}}</span>
                                    </span>
                                @endauth
                                 </span>
                            </div>
                        </div>
                    </div>

                    @if(count($comment->children)>0)
                        @foreach ($comment->children as $childComment)
                             @include('front.layouts.child_comment', ['childComment' => $childComment])
                        @endforeach
                    @endif

                @endforeach
                    {{ $comments->links('front.layouts.comment_pagination')}}

            @endif
        </div><!-- WRAPPER -->

        <div class="comment_form_wrap">
            <div class="comment_img{{ Auth::check() ? ' user' : null}}">
                <svg class="coment_user">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use>
                </svg>
            </div>

            <div class="comment_form_block">
                <h5 class="comment_user">{{ Auth::check() ? Auth::user()->name : 'Гость'}} </h5>
                <form action="{{route('comment.store')}}" method="POST" id="commentForm" class="comment_form">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <input type="hidden" id="parentId" name="parent_id" value="0">
                    <textarea name="massage" id="comment" class="comment_form_fild" cols="30" rows="10"></textarea>
                    @if(Auth::check())
                        <input type="submit" class="comment_btn" value="Отправить">
                    @endif
                </form>
                @guest
                    <div class="comment_valid" id="commentValid"></div>
                    <a  href="{{route('user.register')}}" class="comment_auth_btn" id="registerBtn">Регистрация</a>
                    <a href="{{route('user.auth')}}" class="comment_auth_btn"  id="loginBtn">Войти</a>
                @endguest
            </div>
        </div><!-- FORM -->





    </section>
@endsection



@section('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', (event) => {

            let fancybox;
            const comment = document.getElementById('comment');

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
                                setTimeout(function(){
                                    fancybox.close()
                                    location.reload();
                                }, 2000);
                                console.log(data);
                            }
                            if(!valid){
                                document.querySelector('.fancybox__content').innerHTML = data;
                                sendLogin()
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
                                console.log(valid);
                                return response;
                            }).then( response => response.text())
                            .then(data => {
                                if(valid){
                                    document.querySelector('.fancybox__content').innerHTML = data;
                                    setTimeout(function(){
                                        fancybox.close()
                                        location.reload();
                                    }, 3000);
                                    console.log(data);
                                }
                                if(!valid){
                                    document.querySelector('.fancybox__content').innerHTML = data;
                                    sendRegister();
                                    console.log(data);
                                }
                            }).catch((error) => {
                            //document.querySelector('.fancybox__content').innerHTML = data;
                            console.log(error);
                        });
                    });
                };
            }

            // -- Для не аунтифицированных пользователей
            if(document.getElementById('commentValid')){
                const commentValid = document.getElementById('commentValid');

                document.getElementById('loginBtn').addEventListener('click', function (event) {
                    event.preventDefault();
                    getLogIn();
                    //alert('loginBtn')
                });
                document.getElementById('registerBtn').addEventListener('click', function (event) {
                    event.preventDefault();
                    getRegister();
                    //alert('registerBtn')
                });
                comment.addEventListener('input', function () {
                    commentValid.innerText = 'Sorry… Оставлять комментарии могут только зарегистрированные пользователи';
                }, false);
            }


            // Comments - hide/show Overflow - content
            if(document.querySelectorAll('.comment_text')){

                function checkOverflow(e) {
                    if(e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight){
                        let overflowItem = e.querySelector('.overflow_wrap');
                        overflowItem.style.display = 'flex';
                        e.querySelector('.btn_show').addEventListener('click', function(event) {
                            event.preventDefault();
                            e.style.maxHeight = '100%';
                            overflowItem.style.display = 'none';
                        });
                    }
                }
                document.querySelectorAll('.comment_text').forEach(item => checkOverflow(item));
            }

/*______________*/


            // Comments Like / Dislike
            if(document.querySelectorAll('.available')) {
                document.querySelectorAll('.available').forEach(function (elem) {
                    elem.addEventListener('click', function (event) {
                        event.preventDefault();

                        let formData = {
                            'commentId': elem.dataset.commit_id,
                            'type': elem.dataset.type
                        }
                        //получить ближайшего родителя по селектору
                        function closest(el, selector) {
                            if (Element.prototype.closest) {
                                return el.closest(selector);
                            }
                            let parent = el;
                            while (parent) {
                                if (parent.matches(selector)) {
                                    return parent;
                                }
                                parent = parent.parentElement;
                            }
                            return null;
                        }

                        fetch('{{route('comment.reaction')}}', {
                            method: 'POST', // or 'PUT'
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(formData)
                            })
                            .then(function (response){
                                return response;
                            }).then( response => response.text())
                            .then(data => {
                                let parent = closest(event.target, '.comment_btn_wrap');
                                console.log(parent);
                                parent.innerHTML = data;
                                console.log(data);

                            }).catch((error) => {
                                console.log(error);
                            });
                    });
                });
            }


            // If user doesn't auth  push Like / Dislike - show AUTH FORM
            if(document.querySelectorAll('.unavailable')) {
                document.querySelectorAll('.unavailable').forEach(function (elem) {
                    elem.addEventListener('click', function (event) {
                        event.preventDefault();
                        getLogIn();
                        //alert('Можно только зарегистрированным пользователям!');
                    });
                });
            }

            // Ответ на коментарий.
            if(document.querySelectorAll('.comment_answer')){
                document.querySelectorAll('.comment_answer').forEach(function (item) {
                    item.addEventListener('click', function(event) {
                        //event.preventDefault();

                        const comment = document.getElementById('comment');
                        const form = document.getElementById('commentForm');
                        const link = event.target;

                        if(event.target.dataset.id) {
                            document.getElementById('parentId').value = event.target.dataset.id;
                        }
                        const name = link.parentElement.parentElement.querySelector('.comment_user').innerText + ',  ';
                        comment.textContent = name;

                        function setCaretPosition(ctrl, pos) {
                            // Modern browsers
                            if (ctrl.setSelectionRange) {
                                ctrl.focus();
                                ctrl.setSelectionRange(pos, pos);
                                // IE8 and below
                            } else if (ctrl.createTextRange) {
                                var range = ctrl.createTextRange();
                                range.collapse(true);
                                range.moveEnd('character', pos);
                                range.moveStart('character', pos);
                                range.select();
                            }
                        }
                        setCaretPosition(comment, name.length);
                        window.setTimeout( ()=>{ form.scrollIntoView({behavior: "smooth"}) }, 50 );
                    })

                });


            }















        });// --- DOM LOUDER


    </script>
@endsection
