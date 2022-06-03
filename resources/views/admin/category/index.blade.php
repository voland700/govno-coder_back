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
    <x-adminlte-card title="Категории статей" class="col-lg-9" collapsible removable maximizable>



    </x-adminlte-card>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
