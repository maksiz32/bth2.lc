@extends('layouts.nolinks')
@section('title', "Подтверждение в AD")
@section('content')
<article class="container main_page">
    <br/>
    <br/>
    @isset ($message)
    <div class="alert alert-danger text-center" role="alert">
        {{ $message }}
    </div>
    @endisset

    <form action="{{ action('AdWorkController@adViewEdit') }}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
        <div class="row">
            <input type="hidden" name="ldapuser" value="{{ old('ldapuser', $ldapuser) }}">
            <input type="hidden" name="companyDN" value="{{ old('companyDN', $companyDN) }}">
            <input type="hidden" name="company" value="{{ old('company', $company) }}">
            <div class="col-12 text-center">
                <label for="pass" class="text-left">
                    Подтвердите доменный пароль пользователя 
                    <span>{{ $ldapuser }} </span> 
                    для работы с подразделением: 
                    <span>{{ $company }}</span>
                </label>
                <input type="password" class="form-control form-control-sm" name="pass" required>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Войти</button>
                <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
            </div>
        </div>
    </form>
</article>
@endsection
