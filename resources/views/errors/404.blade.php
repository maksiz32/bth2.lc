@extends('layouts.app')
@section('title', "Техническая страница")
@section('content')
<article class="container main_page">
    <p>
    <h2>Запрошенная страница не надена.</h2>
    </p>
    <p>
    <h3>Нажмите кнопку назад и попробуйте еще раз позднее.</h3>
    </p>
    <a href="{{ url()->previous() }}" class="btn btn-primary">Назад</a>
</article>
@endsection

