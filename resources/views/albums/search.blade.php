@extends('layouts.app')
@section('title', "Поиск по видео-файлам Филиала")
@section('content')
<div class="container-fluid main_page top-110">
<div class="row">
    <div class="col-lg-12">
        @if ($message = Session::get('status'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('status') }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
    {{ $notes->links() }}
    @if ($notes->count())
    @foreach ($notes as $noteall)
    <div class="row justify-content-center">
        <div class="text-center">
	<div class="video_content">
		{!! $noteall->name !!}
	</div>	
	<div class="video">
		<video src="{{ asset('/video/'.$noteall->file) }}" width="320" height="240" controls preload></video>
	</div>
        </div>
    </div>
    <br/>
    @endforeach
    @else
    <div class="row justify-content-center">
        <div class="col-12 text-center">
        <h3><span class="text-uppercase">Ничего не найдено</span></h3>
        </div>
        <div class="col-12 text-center">
        <h4>Нажмите кнопку назад и попробуйте еще раз</h4>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Назад</a>
    </div>
    @endif
    {{ $notes->links() }}
    </div>
</div>
</div>
@endsection