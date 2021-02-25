@extends('layouts.app')
@section('title', "Изменение адреса рассылки поздравлений")
@section('content')
<div class="container">
        @if ($message = Session::get('status'))
            <div class="alert alert-success" role="alert">
                <?php echo (html_entity_decode(Session::get('status')));?>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
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
    <div class="row">
        <div class="colcol-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Смена адреса рассылки</div>
@foreach($mail as $mails)
                <div class="panel-body">
                    Текущий адрес: {{ $mails->email }}
                    <form class="form-horizontal" method="POST" action="{{ route('chmail') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{ $mails->id }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-12 control-label">E-Mail Address</label>

                            <div class="col-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $mails->email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    Изменить адрес рассылки
                                </button>
                            </form>
                </div>
@endforeach
            </div>
            Есть рассылки:
            <ul>
                <li> direkc@bryansk.rgs.ru - Только Дирекция</li>
                <li> regions@bryansk.rgs.ru - Районы</li>
                <li> allbryansk@bryansk.rgs.ru - И Дирекция и Районы</li>
            </ul>
        </div>
    </div>
</div>
@endsection
                        