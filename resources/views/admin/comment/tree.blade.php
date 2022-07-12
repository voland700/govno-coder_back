@extends('adminlte::page')

@section('title', 'Список комментариев')

@section('content_header')
    <h1>Список коментариев: {{$post->name}}</h1>
@stop

@section('content')

    <div class="col-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th style="width: 60%">Коментарий</th>
                        <th style="width: 20px">Active</th>
                        <th style="width: 20px">Пользователь</th>
                        <th style="width: 100px">Дата</th>
                        <th style="width: 40px">Редактировать</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $delimiter = '<span class="delimiter"></span>';
                    @endphp
                    @foreach ($comments as $comment)
                        <tr>
                            <td class="text-center">{{$comment->id}}</td>
                            <td class="admin-comment-t"><span class="admin-comment-text">{{$comment->short}}</span></td>
                            <td class="text-center">
                                @if ($comment->active === 0)
                                    <span class="pale-icon"><i class="far fa-check-circle"></i></span>
                                @endif
                                @if ($comment->active === 1)
                                    <span class="green-icon"><i class="far fa-check-circle"></i></span>
                                @endif
                            </td>
                            <td>{{$comment->user->name}}</td>
                            <td class="text-center">{{$comment->created_at}}</td>
                            <td>
                                <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                <form method="POST" action="{{ route('comment.destroy', $comment->id) }}" class="formDelete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete" onclick="return confirm('Подтвердите удаление')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @if(count($comment->children)>0)
                            @foreach ($comment->children as $childComment)
                                @include('admin.comment.child_comments', ['childComment' =>$childComment])
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <p></p>
            </div>
            <!-- /.card-footer-->
        </div>
        {{ $comments->links() }}
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')

@stop
