@extends('layouts.app')
@section('title', "Изменить адреса уведомлений при Заказе авто")
@section('content')
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
    <form action="{{ action('AddrEmailController@saveNew') }}" method="post">
    <div class="form-row">
        @if($mail->id)
        {{ method_field('PUT') }}
        <input type="hidden" name="id" value="{{$mail->id}}">
        @endif
        {{ csrf_field() }}
            <div class="form-group col-12">
                Используется для: {{App\NewMail::setMailNameSource(2)}}
            </div>
            <div class="form-group col-lg-6">
                <label for="email" class="control-label small">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $mail->email) }}" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="who" class="control-label">Target/ Used:</label>
                <input type="text" class="form-control" name="who" value="{{ old('who', $mail->who) }}" required>
            </div>
    </div>  
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
    </form>
</div>
@endsection
