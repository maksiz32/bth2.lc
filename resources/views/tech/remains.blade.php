@extends('layouts.app')
@section('title', 'Ввод остатков')
@section('content')
<article class="container main_page">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Модель</th>
                <th>Картридж</th>
                <th>Категория</th>
                <th>Остатки</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teches as $tech)
            <tr class="remains-tr" onclick="document.location.href = '/rem-edit/{{$tech->id}}'">
                <td>
                    <img src="{{ asset('img/tech/'.$tech->photo) }}" class="img-thumbnail h110" />
                </td>
                <td>
                    {!! $tech->tech !!}
                </td>
                <td @if($tech->count <= 5) {{_('class=td-red')}}@endif>
                    {{ $tech->model }}
                </td>
                <td>
                    {{ $tech->category }}
                </td>
                <td @if($tech->count <= 5) {{_('class=td-red')}}@endif>
                    {{$tech->count}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</article>
@endsection

