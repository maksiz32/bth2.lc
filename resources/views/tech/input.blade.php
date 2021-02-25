@extends('layouts.app')
<?php $h = ($tech->id) ? "Редактирование техники " . $tech->tech : "Добавление новой техники" ?>
@section('title', $h)
@section('content')
@push("head")
<script>
      function addName(cb, mat) {
    cb = document.getElementById(cb);
	mat = document.getElementById(mat);
    if (cb.checked) {
		mat.setAttribute('style', 'display:block');
	} else {
		mat.setAttribute('style', 'display:none');
	}
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
            <form action="{{ action('TechController@store') }}" method="POST" enctype="multipart/form-data">
    @if ($tech->id)
                {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $tech->id) }}">
    @endif
                {{ csrf_field() }}
    <div class="row">
        <div class="form-group col-lg-12">
    @if ($tech->id)
    <img src="{{ asset('/img/tech/'.$tech->photo) }}" class="img-thumbnail h110">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="sw1" name="sw1" onchange='addName("sw1", "photo1");'>
                <label class="custom-control-label" for="sw1">Будем менять картинку?</label><br />
                <div style="display:none" class="form-row" id="photo1">
                    <label for="photo1">Выберите изображение устройства:</label>
                    <input type="file" class="form-control-file" name="photo1" required>
                </div>
            </div>
    @else
            <label for="photo1">Выберите изображение устройства:</label>
            <input type="file" class="form-control-file" name="photo1" required>
    @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            <label for="tech" class="control-label">Модель устройства:</label>
            <input type="text" class="form-control" name="tech" value="{{ old('tech', $tech->tech) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            <label for="model" class="control-label">Модель картриджа:</label>
            <input type="text" class="form-control" name="model" value="{{ old('model', $tech->model) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="category" class="col-md-4 control-label">Категория устройства:</label>
            <select name="category" required>
                <option value="1">Принтеры</option>
                <option value="2">Копиры</option>
                <option value="3">МФУ</option>
            </select>
        </div>
    </div>
    <div class="row">  
        <button type="submit" class="btn btn-primary">Сохранить</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
    </div>
</article>
@endsection

