@extends('layouts.app')
@section('title', "Добавление / изменение системы в Базe знаний")
@section('content')
@push("head")
<div class="container top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-warning" role="alert">
            {{$message}}
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
    <form action="{{ action('WikiController@inputSys') }}" method="post">
    <div class="form-row">
        {{ csrf_field() }}
        @if ($system->id)
        {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $system->id) }}">
        @endif
            <div class="form-group col-md-9">
                <label for="system" class="control-label">Имя системы:</label>
                <input type="text" class="form-control" name="system" value="{{old('system', $system->system)}}" required>
            </div>
    </div>
        @if ($system->id)
        <button type="submit" class="btn btn-primary">Изменить</button>
        @else
        <button type="submit" class="btn btn-primary">Добавить</button>
        @endif
    </form>
</div>
@endsection
