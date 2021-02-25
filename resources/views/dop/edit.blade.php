@extends('layouts.nonstyle')
@section('title', "Редактирование " . $edit->nameF)
@section('content')
@push("head")
    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
    <link href="{{ asset('/css/wbn-datepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/wbn-datepicker.js') }}"></script>
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
<script>
    $(function(){
        $('.wbn-datepicker').datepicker();
    });
</script>
@endpush
<div class="container">
        <form action="{{ action('InputController@saveOne') }}" method="post" enctype="multipart/form-data">
    <div class="row">
    <figure class="figure col-lg-5">
        @if($edit->photo !== null)
        <img src="{{ asset($edit->photo) }}" class="figure-img img-fluid rounded img-thumbnail" alt='Фотография {{$edit->nameF." ".$edit->nameN." ".$edit->nameOt}}'>
        @else
        <img src="{{ asset('/img/nophoto.png') }}" class="figure-img img-fluid rounded img-thumbnail" alt='Фотографии еще нет'>
        @endif
        <figcaption class="figure-caption text-left">Фото {{$edit->nameF." ".$edit->nameN." ".$edit->nameOt}}</figcaption>
    </figure>
        <div class="col-lg-7">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="sw1" name="sw1" onchange='addName("sw1", "photo");'>
                <label class="custom-control-label" for="sw1">Будем менять картинку?</label><br />
                <div style="display:none" class="form-row" id="photo">
                    <label for="photo">Выберите файл:</label>
                    <input type="file" class="form-control-file" name="photo" accept="image/*">
                </div>
        </div>
        </div>
    </div>
        {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $edit->id) }}">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="nameF" class="control-label">Фамилия:</label>
                <input id="nameF" type="text" class="form-control" name="nameF" value="{{ old('nameF', $edit->nameF) }}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="nameN" class="control-label">Имя:</label>
                <input id="nameN" type="text" class="form-control" name="nameN" value="{{ old('nameN', $edit->nameN) }}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="nameOt" class="control-label">Отчество:</label>
                <input id="nameOt" type="text" class="form-control" name="nameOt" value="{{ old('nameOt', $edit->nameOt) }}" required>
            </div>
        </div>
            <div class="form-group col">
                <label for="dolzh" class="control-label">Должность:</label>
                <input id="dolzh" type="text" class="form-control" name="dolzh" value="{{ old('dolzh', $edit->dolzh) }}" required>
            </div>
            <div class="form-group col">
                <label for="work" class="control-label">Подразделение:</label>
                <input id="work" type="text" class="form-control" name="work" value="{{ old('work', $edit->work) }}" required>
            </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="date" class="control-label">Дата рождения:</label>
                <input id="date" type="date" class="form-control wbn-datepicker" name="date" value="{{ old('date', $edit->date) }}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="phone" class="control-label">Номер сотового телефона:</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone', $edit->phone) }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </form>
</div>
@endsection
