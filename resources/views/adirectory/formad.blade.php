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
        <h2 class="form-check-title">Выберите дальнейшее действие</h2>
        <section class="form-check-redirect">
        <input class="form-check__input" type="radio" name="redirect-link" id="redirect-link1" 
        value="html" checked>
        <label class="form-check__lable" id="redirect-label1" for="redirect-link1">Внести изменения в УЗ/Получить html-подписи</label>
        <input class="form-check__input" type="radio" name="redirect-link" id="redirect-link2" 
        value="photo">
        <label class="form-check__lable" id="redirect-label2" for="redirect-link2">Изменить фотографии в УЗ</label>
        </section>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Войти</button>
                <button type="reset" class="btn btn-secondary">Отмена</a>
            </div>
        </div>
    </form>
</article>
<script>
    function isCheck() {
        if ($('#redirect-link1').prop('checked')) {
            $('#redirect-label1').addClass('form-check__checked');
            $('#redirect-label2').removeClass('form-check__checked');
        } else {
            $('#redirect-label2').addClass('form-check__checked');
            $('#redirect-label1').removeClass('form-check__checked');
        }
    }
$(document).ready(function() {
    $('#redirect-label1').addClass('form-check__checked');
        $('#redirect-label1').on('click', function(){
            $('#redirect-link1').prop('checked', true);
            $('#redirect-link2').prop('checked', false);
            isCheck();
        });
        $('#redirect-label2').on('click', function(){
            $('#redirect-link2').prop('checked', true);
            $('#redirect-link1').prop('checked', false);
            isCheck();
        });
    });
</script>
@endsection
