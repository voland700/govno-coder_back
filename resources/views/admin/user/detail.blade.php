@extends('adminlte::page')

@section('title', 'Информация о пользователе')

@section('content_header')
    <h1>Пользователь: {{$user->name }}</h1>
@stop

@section('content')

    <x-adminlte-card class="col-lg-6" title="Данные пользователя" theme="lightblue" theme-mode="outline"
                     icon="fas fa-lg fa-user-circle" header-class="text-uppercase rounded-bottom border-info"
                     removable>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 10px">№</th>
                <th> </th>
                <th> </th>
            </thead>
            <tbody>
            <tr>
                <td>1.</td>
                <td><b>Имя:</b></td>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <td>2.</td>
                <td><b>Email:</b></td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td>3.</td>
                <td><b>Дата регистрации:</b></td>
                <td>{{$user->created_at}}</td>
            </tr>
            </tbody>
        </table>
    </x-adminlte-card>
@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')

@stop
