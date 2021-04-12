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
@foreach($ouPersons as $pers)
    <form action="{{ action('AdWorkController@adModify') }}" method="post" id="f-{{$loop->index}}">
        <div class="row hide">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" name="ldapuser" value="{{ old('ldapuser', $ldapuser) }}">
            <input type="hidden" name="ldappass" value="{{ old('ldappass', $ldappass) }}">
            <input type="hidden" name="companyDN" value="{{ old('companyDN', $companyDN) }}">
        </div>
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
                <input class="personline-group-file" type="file" 
                id="i-{{$loop->index}}" placeholder="Выберите фото на компьютере, чтобы изменить в Домене">
                <button class="personline-group-btn" type="submit">Поменять</button>
            </div>
        </section>
    </form>
@endforeach
</main>
    <script>
        function modifyInner(id) {
            const elFormM = document.getElementById('f-'+id);
            // const elDescr = document.getElementById('line-'+id);
            const elDiv = document.getElementById('h-'+id);
            const elInput = document.getElementById('i-'+id);
            const elDn = document.getElementById('dn-'+id);
            const blur = document.getElementById('blur');
            const body = document.getElementsByTagName('body')[0];
            const addr = window.location.origin+'//'; //+'/admod'
            let top = Math.abs(body.getBoundingClientRect().top);

            body.classList.add('overflow');
            blur.classList.remove('hide');
            blur.classList.add('blur');
            elDn.setAttribute('name', 'dn');
            elDiv.classList.remove('hide');
            elFormM.classList.remove('hide');
            document.getElementById('line-'+id).setAttribute('style', 'z-index: 2');
            elDiv.setAttribute('style', 'z-index: 2');
            elInput.setAttribute('name', 'i-'.id);
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
</article>
@endsection
