@extends('layouts.app')
@section('title', "Создание или редактирование ссылок")
@section('content')
<article class="container main_page">
    @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
    <form action="{{ action('LinkController@save') }}" method="post">
        {{ method_field('PUT') }}
        @if(!isset($links))
            <input type="hidden" name="id" value="{{ old('id') }}">
        @else
            <input type="hidden" name="id" value="{{ $links->id }}">
        @endif
        {{ csrf_field() }}
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="name" class="control-label">Название ссылки:</label>
        @if(!isset($links))
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
        @else
            <input type="text" class="form-control" name="name" value="{{ $links->name }}" required>
        @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="path" class="control-label">URL адрес:</label>
        @if(!isset($links))
            <input type="text" class="form-control" name="path" value="{{ old('path') }}" required>
        @else
            <input type="text" class="form-control" name="path" value="{{ $links->path }}" required>
        @endif
        </div>
    </div>
    <div class="row">  
        <button type="submit" class="btn btn-primary">Сохранить</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
    </div>
</article>
@endsection
