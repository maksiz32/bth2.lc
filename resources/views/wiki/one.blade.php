@extends('layouts.app')
@section('title', "База знаний ИТ - ".$wiki->system." - ".$wiki->error)
@section('content')
@push('head')
<style>
    body {
        background-color: #e9e9e9;
    }
    .breadcr {
        margin-bottom: -20px;
    }
    .breadcrumb, .breadcrumb-item {
        background-color: #e9e9e9 !important;
    }
    .fileW {
        font-size: x-small;
    }
    .btnWiki {
        margin: -10px 0 20px 0;
    }
</style>
<script>
$(document).ready(function(){
    $('.hideSpeanerWiki').css('display', 'none');
    $('.btnWiki').css('display', 'inline-block');
    $('.btnWiki').on('click',function(){
        $(this).css('display','none');
        $('.hideSpeanerWiki').css('display', 'block');
    });
});
</script>
@endpush
<article class="container-fluid top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
            <div class="breadcr text-mono" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/wiki">База знаний</a></li>
                    <li class="breadcrumb-item"><a href="{{action('WikiController@systemOne',['id'=>$wiki->id_systems])}}">{{$wiki->system}}</a></li>
                    <li class="breadcrumb-item">{{$wiki->error}}</li>
                </ol>
            </div>
    <div class="row mt-3">
        <div class="col-md-9" id="wikiText">
            <div class="redRightBorder">
            <div class="ml-5">
                <h3>{{$wiki->error}}</h3>
                <hr>
                {!!$wiki->fix!!}
            </div>
            <div class="ml-5 mt-3">
                <a class="btn btn-info" href="{{action('WikiController@viewWiki',['id'=>$wiki->id])}}">
                    Изменить
                </a>
                <a class="btn btn-danger" href="#" OnClick="return confirm('Подтвердите удаление элемента')">
                    Удалить
                </a>
            </div>
            </div>
        </div>
        <div id="files" class="col-md-3 text-center">
            @if(count($files) > 0)
            <div class="row">
            @foreach($files as $file)
            <div class="col-sm-6">
            <a href="{{asset($file->path)}}" target="_blanck">
                <figure>
                    <img src="{{asset($file->type)}}">
                    <figcaption class="fileW">{{$file->name}}</figcaption>
                </figure>
            </a>
                @if(RGSPortal::isAdmin(getenv('REMOTE_USER')))
                <a class="btn btn-danger btn-sm btnWiki" 
                   href="{{action('WikiController@delFile',['id'=>$file->id])}}">
                    Удалить
                </a>
            <div class="hideSpeanerWiki spinner-grow spinner-grow-sm" role="status" 
                 aria-hidden="true" style="display: none">
                Удаляю, подождите
            </div>
                @endif
            </div>
            @endforeach
            </div>
            @endif
        </div>
    </div>
</article>
@endsection
