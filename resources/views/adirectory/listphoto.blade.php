@extends('layouts.nolinks')
@section('title', "Редактирование фото")
@section('content')
<article class="container main_page">
    @if ($message = Session::get('message'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('message') }}
    </div>
    @endif

    <form action="{{ action('AdWorkController@adModify') }}" method="post" id="formR">
        <div class="row">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" name="ldapuser" value="{{ old('ldapuser', $ldapuser) }}">
            <input type="hidden" name="ldappass" value="{{ old('ldappass', $ldappass) }}">
            <input type="hidden" name="companyDN" value="{{ old('companyDN', $companyDN) }}">
        </div>
@foreach($ouPersons as $pers)
    <section class="personline" id="line-{{$loop->index}}" app-data="{{$loop->index}}">
        <input type="hidden" id="dn-{{$loop->index}}" value="{{ $pers['dn'] }}">
            <div class="personline__img personline__rounded" app-data="{{$loop->index}}">
                @if (isset($pers['thumbnailphoto'][0]))
                <img width="60" height="60" class="personline__rounded" app-data="{{$loop->index}}" 
                    src="{{'data:image/jpeg;base64,'.base64_encode($pers['thumbnailphoto'][0])}}">
                @else
                <span class="personline__noimg" app-data="{{$loop->index}}">
                    Нет<wbr> Фото
                </span>
                @endif
            </div>
            <p class="personline-txt" app-data="{{$loop->index}}">
                <strong app-data="{{$loop->index}}">
                    {{ $pers['name'][0] }}
                </strong>
            {{ (isset($pers['title'][0]))?" - ".$pers['title'][0]:'' }}
            </p>
        <div class="hide personline-group" id="h-{{$loop->index}}">
            <label for="h-{{$loop->index}}">Выберите фото на компьютере, чтобы изменить в Домене</label>
            <input class="personline-group-file" type="file" 
            id="i-{{$loop->index}}" placeholder="Выберите фото на компьютере, чтобы изменить в Домене">
        </div>
    </section>
@endforeach
    <script>
        function modifyInner(id) {
            let el = document.getElementById('h-'+id);
            el.classList.remove('hide');
        }
        document.getElementById('formR').onclick = function(ev) {
            let target = ev.target;
            let targetId = target.getAttribute('app-data');
            if (targetId != null) {
                modifyInner(targetId);
            }
        }
        // el.forEach(function(oneEl) {
        //     let p = oneEl.addEventListener("click", function(){modifyInner(2)}, false);
        //     console.log(p);
        // })
    </script>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="reset" class="btn btn-secondary">Отмена</button>
            </div>
        </div>
    </form>
</article>
@endsection
