@extends('layouts.app')
@section('title', "Видео-файлы Филиала")
@section('content')
<article class="container-fluid main_page top-110">
    @if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    @if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="alert alert-dark alert-dismissible fade show" role="alert">
    <form action="{{ action('AlbumController@searchVideo') }}" method="post">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="col">
                <label for="videoSearch">Поиск видео по названию:</label>
            </div>
            <div class="col">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">?</div>
                    </div>
                    <input type="text" class="form-control" name="videoSearch" id="videoSearch" required="">
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary mb-2">Поиск</button>
            </div>
        </div>
    </form>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
<div class="row">
    <div class="col-12 text-center alert alert-secondary" role="alert">
        <a class="btn btn-primary" role="button" href="/new_video">
            Добавить новое видео
        </a>
    </div>
</div>
    {{ $videos->links() }}
    <div class="row justify-content-center">
    @foreach($videos as $video)
    <div class="col-md-3 mar15 alert alert-info text-center" role="alert">
        <div class="text-center">
	<div class="video_content">
		{!! $video->name !!}
	</div>	
	<div class="video">
		<video src="{{ asset('/video/'.$video->file) }}" width="320" height="240" controls preload></video>
	</div>
            <p><a href="{{ action('AlbumController@inputVideo', ['id' => $video->id]) }}" class="btn btn-primary btn-block">
                        Редактировать
                </a></p>
                <p><a href="{{ action('AlbumController@deleteVideo', ['id' => $video->id]) }}" 
                      OnClick="return confirm('Подтвердите удаление элемента')" class="btn btn-danger btn-block">
                        Удалить
                    </a></p>
        </div>
    </div>
    @endforeach
    </div>
@else
        {{ $videos->links() }}
    <div class="row justify-content-center">
    @foreach($videos as $video)
    <div class="col-md-3 mar15 alert alert-info text-center" role="alert">
        <div class="text-center">
	<div class="video_content">
		{!! $video->name !!}
	</div>	
	<div class="video">
		<video src="{{ asset('/video/'.$video->file) }}" width="320" height="240" controls preload></video>
	</div>
        </div>
    </div>
    @endforeach
    </div>    
    @endif
    {{ $videos->links() }}
</article>
@endsection

