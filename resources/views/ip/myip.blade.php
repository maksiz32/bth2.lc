@extends('layouts.app')
@section('title', "IP-адрес")
@section('content')
<div class="container">
    <div class="panel panel-primary alert alert-success">
    <div class="row mar15 alert alert-info" role="alert">
        <div class="col-12 text-left">
            <h3 class="m-5">
                <strong>Имя учетной записи (в Домене): </strong>
                <span class="bg-light">{{getenv('REMOTE_USER')}}</span>
                &nbsp;
                <span class="bg-light">@rgs.ru</span>
            </h3>
            <h3 class="m-5">
                <strong>Ваш ip-адрес: </strong>
                <span class="bg-light">{{$ip}}</span>
            </h3>
            <h3 class="m-5">
                <strong>Имя компьютера (ПК): </strong>
                <span class="bg-light">{{gethostbyaddr($ip)}}</span>
            </h3>
        </div>
    </div>
    </div>
</div>
@endsection
