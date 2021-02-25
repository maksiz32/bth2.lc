@extends('layouts.app')
@section('title', 'Вся техника')
@section('content')
<article class="container main_page">
<?php
function categoryName($cat) {
    switch($cat) {
        case 1:
            $cat = "Принтер";
            break;
        case 2:
            $cat = "Копир";
            break;
        case 3:
            $cat = "МФУ";
            break;
    }
    return $cat;
}
?>
    @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
    <div class="row alert alert-danger" role="alert">
        <div class="col-12 text-center">
            <a href="/tech/create" class="btn btn-primary">
                Добавить новое оборудование
            </a>
        </div>
    </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Модель</th>
                <th>Картридж</th>
                <th>Категория</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teches as $tech)
            <tr>
                <td>
                    <img src="{{ asset('img/tech/'.$tech->photo) }}" class="img-thumbnail h110" />
                </td>
                <td>
                    {{ $tech->tech }}
                </td>
                <td>
                    {{ $tech->model }}
                </td>
                <td>
                    {{ categoryName($tech->category) }}
                </td>
                <td>
                <a href="{{ action('TechController@create', ['id' => $tech->id]) }}" class="btn btn-primary btn-block">
                    Изменить
                </a>
                <a href="{{ action('TechController@destroy', ['id' => $tech->id]) }}" 
                   OnClick="return confirm('Подтвердите удаление элемента')" 
                   class="btn btn-danger btn-block">
                    Удалить
                </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</article>
@endsection

