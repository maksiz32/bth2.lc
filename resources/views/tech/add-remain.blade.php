@extends('layouts.app')
@section('title', 'Ввод остатков')
@section('content')
<article class="container main_page">
    <form action="{{action('TechController@saveRemain')}}" method="post">
        Изменить количество расходкников:
            {{ method_field('PUT') }}
            {{ csrf_field() }}
        <input type="hidden" name="rem_id" value="{{$rem->rem_id}}">
        <input type="hidden" name="tech_id" value="{{$rem->tech_id}}">
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Модель</th>
                <th>Картридж</th>
                <th>Остатки</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {!! $rem->tech !!}
                </td>
                <td>
                    {{ $rem->model }}
                </td>
                <td>
                    <input type="text" name="count" value="{{$rem->count}}">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <button type="submit">Ввод</button>
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</article>
@endsection

