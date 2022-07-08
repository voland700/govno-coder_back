@extends('adminlte::page')

@section('title', 'Список арегистрированных пользователей')

@section('content_header')
    <h1>Список пользователей</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif

    <x-adminlte-card title="Список пользователей" class="col-12" collapsible removable maximizable>
        @php
            $heads = [
                ['label' => 'ID', 'width' => 2],
                'Имя',
                ['label' => 'Email','no-export' => true, 'width' => 15],
                ['label' => 'Actions', 'no-export' => true, 'width' => 12],
            ];
            $config = [
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false], ['orderable' => false]],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{ route('admin.users.detail', $user->id) }}" class="btn btn-xs btn-info mx-1 shadow"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    </td>
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
