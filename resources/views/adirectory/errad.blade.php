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
    <a class="button-blue" href="{{ action('AdWorkController@adldapView') }}">
        Попробовать еще раз
    </a>
</article>
@endsection
