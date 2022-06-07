@extends('adminlte::page')

@section('title', 'Список рубрик, категорий статей')

@section('content_header')
    <h1>Рубрики статей</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif

    <a href="{{route('category.create')}}" type="button" class="btn btn-primary mb-3">Добавить</a>
    <x-adminlte-card title="Категории статей" class="col-lg-6" collapsible removable maximizable>
        @php
            $heads = [
                ['label' => 'ID', 'width' => 2],
                'Name',
                ['label' => 'Сортировка', 'width' => 14],
                ['label' => 'Actions', 'no-export' => true, 'width' => 14],
            ];
            $config = [
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td class="text-center">{{$category->sort}}</td>
                <td>
                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-xs btn-info mx-1 shadow"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                    <form method="POST" action="{{ route('category.destroy', $category->id) }}" class="formDelete">
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
