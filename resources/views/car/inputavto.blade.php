@extends('layouts.app')
@section('title', "Добавить/изменить автомобили Компании")
@section('content')
@push("head")
    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('button').on('click',function(){
            $(this).css('display','none');
        })
    });
</script>
@endpush
<div class="container top-130">
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
    <form action="{{ action('CarController@saveAvto') }}" method="post">
    <div class="form-row">
        @if($car->id)
        {{ method_field('PUT') }}
        <input type="hidden" name="id" value="{{$car->id}}">
        @endif
        {{ csrf_field() }}
            <div class="form-group col-lg-3">
                <label for="number" class="control-label small">Номер машины (6 символов, без пробелов):</label>
                <input type="text" class="form-control" name="number" value="{{ old('number', $car->number) }}" required>
            </div>
            <div class="form-group col-lg-3">
                <label for="model" class="control-label">Модель:</label>
                <input type="text" class="form-control" name="model" value="{{ old('model', $car->model) }}" required>
            </div>
            <div class="form-group col-lg-3">
                <label for="driver" class="control-label">Водитель:</label>
                <input type="text" class="form-control" name="driver" value="{{ old('driver', $car->driver) }}" required>
            </div>
            <div class="form-group col-lg-3">
                <label for="phone_driver" class="control-label">Телефон (10 символов):</label>
                <input type="text" class="form-control" name="phone_driver" value="{{ old('phone_driver', $car->phone_driver) }}" required>
            </div>
    </div>  
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </form>
    @if(isset($avtos))
    <br>
    <hr>
    <br>
    <div>
        @foreach($avtos as $avto)
        <p>
            {{'#'.$loop->iteration.'. '.$avto->id.' :: '.$avto->number.' :: '.$avto->model.' :: '.$avto->driver.' :: '.$avto->phone_driver}}
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{action('CarController@inputAvto', ['id' => $avto->id])}}" 
               class="btn btn-success">Редактировать</a>
        </p>
        @endforeach
    </div>
    @endif
</div>
@endsection
