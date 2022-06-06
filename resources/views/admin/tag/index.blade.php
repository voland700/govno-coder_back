@extends('adminlte::page')

@section('title', 'Список тегов для статей')

@section('content_header')
    <h1>Список тегов</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif

    <a href="{{route('tag.create')}}" type="button" class="btn btn-primary mb-3">Добавить</a>
    <x-adminlte-card title="Теги для статей" class="col-lg-6" collapsible removable maximizable>
        @php
            $heads = [
                ['label' => 'ID', 'width' => 2],
                'Name',
                ['label' => 'Actions', 'no-export' => true, 'width' => 14],
            ];
            $config = [
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach($tags as $tag)
            <tr>
                <td>{{$tag->id}}</td>
                <td>{{$tag->name}}</td>
                <td>
                    <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-xs btn-info mx-1 shadow"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                    <form method="POST" action="{{ route('tag.destroy', $tag->id) }}" class="formDelete">
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
