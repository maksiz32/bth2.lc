@extends('layouts.app')
@section('title', "Создание :: редактирование фотоальбомов Филиала")
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
    <form action="{{ action('AlbumController@savePhotoAlbum') }}" method="post">
        <div class="row">
            <div class="form-group col-lg-3">
        @if(isset($photo))
        {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $photo->id) }}">
        {{ csrf_field() }}
            <label for="show" class="control-label">Блокировка просмотра:</label>
        <select name="show" class="form-control" required>
            @if ($photo->show == '2')
            <option value="1" class="form-control">Не доступен к просмотру</option>
            <option value="2" class="form-control" selected>Доступен к просмотру</option>
            @else
            <option value="1" class="form-control" selected>Не доступен к просмотру</option>
            <option value="2" class="form-control">Доступен к просмотру</option>
            @endif
        </select>
        @endif
            </div>
        <div class="form-group col-lg-9">
            <label for="name" class="control-label">Название альбома:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $photo->name) }}" required>
        </div>
    </div>  
        <div class="row">
        <div class="form-group col-lg-12">
            <label for="description" class="control-label">Описание:</label>
            <textarea rows="2" class="form-control" name="description">
            {{ old('description', $photo->description) }}
            </textarea>
        </div>
    </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </form>
</article>
@endsection

