@extends('layouts.app')
@section('title', "Загрузка фотографий в альбом")
@section('content')
@push("headup")
    <link href="{{ asset('/css/newfile.css') }}" rel="stylesheet">
@endpush
@push("head")
<script type="text/javascript">
    function addName(cb, cat) {
        cb = document.getElementById(cb);
        cat = document.getElementById(cat);
	cb.setAttribute('style', 'display:none;');
	cat.setAttribute('style', 'display:block;');
	}
</script>
@endpush
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
    <div class="row mar15 alert alert-info text-center" role="alert">
        <div class="col-12 text-center">{{ $name->name }}
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12" id="forview" style="display:none;">
                            Идёт загрузка фотографий. Пожалуйста подождите
                    <div class="spinner-border text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                        <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true">
                        </span>
                    </div>
        </div>
    </div>
    <form action="{{ action('AlbumController@savePhotos') }}" method="post" enctype="multipart/form-data">
        <div id="forhide">
        <div class="row">
        {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $id) }}">
        {{ csrf_field() }}
            <div class="col-lg-7">
                <label for="photo1">Выберите файл:</label>
                <input type="file" class="form-control-file" name="photo1[]" multiple required  accept="image/*">
            </div>
        </div>
        <br/><br/>
        <button type="submit" onclick='addName("forhide","forview")' class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </div>
        </form>
</article>
@endsection

