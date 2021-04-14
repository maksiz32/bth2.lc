@extends('layouts.nolinks')
@section('title', "Редактирование фото")
@section('content')
<article class="container main_page">
    <div class="hide" id="blur"></div>
    @if ($message = Session::get('message'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('message') }}
    </div>
    @endif
<main id="formR">
    <form method="post" id="formF" enctype="multipart/form-data">
        <div class="row hide">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" name="ldapuser" value="{{ old('ldapuser', $ldapuser) }}">
            <input type="hidden" name="ldappass" value="{{ old('ldappass', $ldappass) }}">
            <input type="hidden" name="companyDN" value="{{ old('companyDN', $companyDN) }}">
        </div>
@foreach($ouPersons as $pers)
        <section class="personline" app-data="{{$loop->index}}" id="line-{{$loop->index}}">
            <input type="hidden" id="dn-{{$loop->index}}" value="{{ $pers['dn'] }}">
                <div class="personline__img personline__rounded" id="img-{{$loop->index}}" app-data="{{$loop->index}}">
                    @if (isset($pers['thumbnailphoto'][0]))
                    <img width="60" height="60" class="personline__rounded" app-data="{{$loop->index}}" 
                        src="{{'data:image/jpeg;base64,'.base64_encode($pers['thumbnailphoto'][0])}}">
                    @else
                    <span class="personline__noimg" app-data="{{$loop->index}}">
                        Нет<wbr> Фото
                    </span>
                    @endif
                </div>
                <p class="personline-txt" app-data="{{$loop->index}}" id="txt-{{$loop->index}}">
                    <strong app-data="{{$loop->index}}">
                        {{ $pers['name'][0] }}
                    </strong>
                {{ (isset($pers['title'][0]))?" - ".$pers['title'][0]:'' }}
                </p>
            <div class="hide personline-group" id="h-{{$loop->index}}">
                <label for="i-{{$loop->index}}">Выберите фото на компьютере, чтобы изменить в Домене</label>
                <input class="personline-group-file" type="file" accept="image/*" 
                id="i-{{$loop->index}}" placeholder="Выберите фото на компьютере, чтобы изменить в Домене">
                <button class="personline-group-btn" type="submit" onclick="sendPhoto({{$loop->index}})">
                    Поменять
                </button>
                <span>Отмена</span>
            </div>
        </section>
@endforeach
    </form>
</main>
<script src="{{asset('/js/changephoto.js')}}"></script>
</article>
@endsection
