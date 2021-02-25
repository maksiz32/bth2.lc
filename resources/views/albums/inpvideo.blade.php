@extends('layouts.app')
@section('title', "Создание :: редактирование видеоальбомов Филиала")
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
    <form action="{{ action('AlbumController@saveVideo') }}" method="post" enctype="multipart/form-data">
        
        @if(!isset($video->id))
        <div class="row">
            <div class="col-lg-7">
                <label for="file1">Выберите файл:</label>
                <input type="file" class="form-control-file" name="file1" accept="video/*">
            </div>
        </div>
        @endif
    <div class="form-row">
        {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $video->id) }}">
        {{ csrf_field() }}
            <div class="form-group col">
                <label for="name" class="control-label">Название видео:</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $video->name) }}" required>
            </div>
    </div>  
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </form>
</article>
@endsection

