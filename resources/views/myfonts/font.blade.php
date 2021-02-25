@extends('layouts.app')
@section('title', "Примеры шрифтов")
@section('content')
@push("head")
<link href="{{ asset('/css/myfonts.css') }}" rel="stylesheet">
<script>
    $(document).ready(function() {
        $('.select').on('change', function () {
        var $fontFam = $('.select :selected').val();
        $('.sel-text').css('font-family', $fontFam);
        })
        
        $('.fontSize').on('change', function() {
        var $fontSize = $('.fontSize :selected').val();
        $('.sel-text').css('font-size', $fontSize);
        })
    });
</script>
@endpush
<article class="container main_page">    
    <div class="form-group row">
        <div class="col-12">
        <label for="font-size">Размер шрифта:</label>
    <select class="fontSize form-control" id="font-size">
        <option value="0.8rem">0.8</option>
        <option value="1rem" selected="">1</option>
        <option value="1.4rem">1.4</option>
        <option value="1.8rem">1.8</option>
        <option value="2rem">2</option>
    </select>
        </div>
        <label for="fontFamily">Сменить шрифт:
            <select class="select form-control col-md-8" id="fontFamily">
        @foreach($myfonts as $font)
            <option value="{{ $font->name }}">{{ $font->name }}</option>
        @endforeach
            </select>
        </label>
        <div class="sel-text col-md-9">
            ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxwz<br/>
            АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЪЩЬЭЮЯ абвгдеёжзийклмнопрстуфхцчшъщьэюя
        </div>
    </div>
    <table class="table table-striped">
        <thead class="thead-dark text-center">
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Пример</th>
            </tr>
        </thead>
        <tbody>
            @foreach($myfonts as $font)
            <tr>
                <th scope="row">
                    {{ $font->name }}
                </th>
                <th>
                    <span class="{{ $font->name }}" style="font-size: 1.5em;">
                        ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxwz<br/>
                        АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЪЩЬЭЮЯ абвгдеёжзийклмнопрстуфхцчшъщьэюя
                    </span>
                </th>
            </tr>
            @endforeach
            </tbody>
    </table>
</article>
@endsection
