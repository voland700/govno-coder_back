@extends('adminlte::page')

@section('title', 'Список статей блога')

@section('content_header')
    <h1>Список статей</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif

    <a href="{{route('post.create')}}" type="button" class="btn btn-primary mb-3">Добавить</a>
    <x-adminlte-card title="Список статей" class="col-12" collapsible removable maximizable>
        @php
            $heads = [
                ['label' => 'ID', 'width' => 2],
                'Name',
                ['label' => 'Рубрики','no-export' => true, 'width' => 15],
                ['label' => 'Активность','no-export' => true, 'width' => 5],
                ['label' => 'Actions', 'no-export' => true, 'width' => 8],
            ];
            $config = [
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false], ['orderable' => false], ['orderable' => false]],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->name}}</td>
                    <td>
                        @foreach($post->categories as $category)
                            <span class="post_category_list">{{$category->name}}</span>@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        @if ($post->active === 1)
                            <span class="green-icon"><i class="far fa-check-circle"></i></span>
                        @else
                            <span class="pale-icon"><i class="far fa-check-circle"></i></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-xs btn-info mx-1 shadow"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        <form method="POST" action="{{ route('post.destroy', $post->id) }}" class="formDelete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger mx-1 shadow delete" onclick="return confirm('Подтвердите удаление')"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>



    </x-adminlte-card>

@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
