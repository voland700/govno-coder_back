@extends('adminlte::page')

@section('title', 'Редактирование коментария пользователя')

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
    <form role="form" method="post" id="form" action="{{  route('comment.update', $comment->id) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <x-adminlte-card title="Комментарий пользователя" class="col-lg-9" body-class="pb-3" collapsible removable maximizable>
            <div class="row">
                @php
                    $configSwitch = [
                        'state' => $comment->active == 1 ? true : false
                    ];
                @endphp
                <div class="col-12">
                <x-adminlte-input-switch name="active" data-on-color="success" data-off-color="danger" :config="$configSwitch"   />
                </div>
                <table class="table table-bordered col-md-6">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Reason</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Пользователь:</td>
                        <td>{{$comment->user->name}}</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Дата:</td>
                        <td>{{$comment->created_at}}</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Dislike:</td>
                        <td><i class="text-primary far fa-thumbs-down mr-2"></i>{{$comment->getDislikeCount()}}</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Like:</td>
                        <td><i class="text-success far fa-heart mr-2"></i>{{$comment->getLikeCount()}}</td>
                    </tr>
                    </tbody>
                </table>
                <x-adminlte-textarea name="massage" label="Текст комментария" rows=3 fgroup-class="col-12 mt-3">{!! $comment->massage !!}</x-adminlte-textarea>
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
        $("[name='active']").bootstrapSwitch({
            'state' : {{$comment->active == 1 ? true : false}}
        });
    </script>
@stop
