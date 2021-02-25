@extends('layouts.app')
@section('title', "Все ССЫЛКИ")
@push('head')
<script>
    $(document).ready(function() {
        var $countL = $("[name='link']").length;
        console.log($countL);
        var $j=0;
        for($i=1; $i<=$countL; $i++) {
            $('#link'+$i).delay($j).fadeIn(1000);
            $j+=200;
        }
    });
</script>
@endpush
@section('content')
<article class="container main_page">
    @if ($message = Session::get('status'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('status') }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
    <div class="row alert alert-info" role="alert">
        <div class="col-12 text-center">Список ресурсов Компании:
        </div>
    </div>
<noscript>Включите JavaScript в настройках браузера</noscript>
    @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
    <div class="row alert alert-danger" role="alert">
        <div class="col-12 text-center">
            <a href="/new_link" class="btn btn-primary">
                Создать ссылки
            </a>
        </div>
    </div>
    <div class="row">
    @foreach($links as $link)
        @if(($loop->index % 4 === 0) && (!$loop->first))
    </div><br/><div class="row">
        @endif
        <div class="col-lg-3">
            <div class="card border-dark text-center" id="link{{$loop->index + 1}}" name="link" style='display: none;'>
                <a href="{{ $link->path }}" class="text-dark" target="_blank">
                    <div class="card-body">
                        <h3><b><p class="card-text"><span class="text-link">
                            {!! $link->name !!}
                                    </span></p></b></h3>
                    </div>
                </a>
            <div class="card-footer">
                <a href="{{ action('LinkController@edit_link', ['id' => $link->id]) }}" class="btn btn-primary btn-block">
                    Отредактировать ссылку
                </a>
                <a href="{{ action('LinkController@delete', ['id' => $link->id]) }}" 
                   OnClick="return confirm('Подтвердите удаление элемента')" 
                   class="btn btn-danger btn-block">
                    Удалить ссылку
                </a>
            </div>
            </div>
        </div>
    @endforeach
    </div>
    @else
    <div class="row">
    @foreach($links as $link)
        @if(($loop->index % 4 === 0) && (!$loop->first))
    </div><br/><div class="row">
        @endif
        <div class="col-lg-3">
            <div class="card border-dark text-center" id="link{{$loop->index + 1}}" name="link" style='display: none;'>
                <a href="{{ $link->path }}" class="text-dark" target="_blank">
                    <div class="card-body">
                        <h3><b><p class="card-text"><span class="text-link">
                            {!! $link->name !!}
                                    </span></p></b></h3>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
    </div>
    @endif
</article>
@endsection
