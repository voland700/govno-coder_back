@extends('adminlte::page')

@section('title', 'Список новостей')

@section('content_header')
    <h1>Список новостей</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif

    <a href="{{route('news.create')}}" type="button" class="btn btn-primary mb-3">Добавить</a>
    <x-adminlte-card title="Список новостей" class="col-12" collapsible removable maximizable>
        @php
            $heads = [
                ['label' => 'ID', 'width' => 2],
                'Name',
                ['label' => 'Дата','no-export' => true, 'width' => 8],
                ['label' => 'Активность','no-export' => true, 'width' => 5],
                ['label' => 'Actions', 'no-export' => true, 'width' => 8],
            ];
            $config = [
                'order' => [[1, 'desc']],
                'columns' => [null, null, ['orderable' => false], ['orderable' => false]],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($news as $new)
                <tr>
                    <td>{{$new->id}}</td>
                    <td><a href="{{route('new', $new->slug)}}" target="_blank" class="one-line">{{$new->title}}</a></td>
                    <td>{{$new->getNewsDate()}}</td>
                    <td>
                        @if ($new->active === 1)
                            <span class="green-icon"><i class="far fa-check-circle"></i></span>
                        @else
                            <span class="pale-icon"><i class="far fa-check-circle"></i></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('news.edit', $new->id) }}" class="btn btn-xs btn-info mx-1 shadow"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        <form method="POST" action="{{ route('news.destroy', $new->id) }}" class="formDelete">
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
