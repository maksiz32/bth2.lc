@extends('layouts.app')
@if ($mounth)
<?php
$p="Все сотрудники, родившиеся в месяце :: " . $mounth;
?>
@else
<?php
$p="Все сотрудники";
?>
@endif
@section('title', $p)
@section('content')
@push("headup")
    <link href="{{ asset('/css/newfile.css') }}" rel="stylesheet">
@endpush
@push("head")
<?php
function rusMounth($mounth=null) {
    $rMth = [
        "1" => "Январь",
        "2" => "Февраль",
        "3" => "Март",
        "4" => "Апрель",
        "5" => "Май",
        "6" => "Июнь",
        "7" => "Июль",
        "8" => "Август",
        "9" => "Сентябрь",
        "10" => "Октябрь",
        "11" => "Ноябрь",
        "12" => "Декабрь",
    ];
    echo $rMth[$mounth];
}

function mounthP($data=null) {
    $data = explode("-", $data);
    $mounth = $data[1];
    $rMth = [
        "01" => " января ",
        "02" => " февраля ",
        "03" => " марта ",
        "04" => " апреля ",
        "05" => " мая ",
        "06" => " июня ",
        "07" => " июля ",
        "08" => " августа ",
        "09" => " сентября ",
        "10" => " октября ",
        "11" => " ноября ",
        "12" => " декабря ",
    ];
    (isset($data[2]))?$result = $data[0].$rMth[$mounth].$data[2]:$result = $data[0].$rMth[$mounth];
    return $result;
}
?>
<script type="text/javascript">
    function addName(cb, cat) {
        cb = document.getElementById(cb);
        cat = document.getElementById(cat);
	cb.setAttribute('style', 'display:none;');
	cat.setAttribute('style', 'display:block;');
	}
</script>
@endpush
<div class="container-fluid">
    <div class="row top-110 text-center">
        <div class="alert alert-info col-md-4" role="alert">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Выбрать месяц</button>
            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="row">
                            @for ($i=1; $i<13; $i++)
                            <div class="col-3 mar15">
                                <a class="btn btn-primary" role="button" href="{{ action('AllController', ['mounth' => $i]) }}">
                <?php rusMounth($i)?>
                                </a>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-primary" role="button" href="/all">
                Отобразить всех
            </a>
        </div>
        @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
        <div class="col-md-4 alert alert-secondary" role="alert">
            Текущий адрес рассылки: 
            @if(isset($mail)){{ $mail->email }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-primary" role="button" href="/email">
                Изменить адрес
            </a>
            @else
            Адрес рассылки поздравлений не установлен
            <a class="btn btn-primary" role="button" href="/email">
            Добавить адрес
            </a>
            @endif
        </div>
        @endif
        <div class="col-md-4 alert alert-dark" role="alert">
            <form action="{{ action('InputController@search') }}" method="post">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col">
                        <label for="column">Поиск по:</label>
                        <select name="column" class="form-control" id="column">
                            <option value="nameF">Фамилия</option>
                            <option value="dolzh">Должность</option>
                            <option value="work">Подразделение</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="textSearch">Строка поиска</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">?</div>
                            </div>
                            <input type="text" class="form-control" name="textSearch" id="textSearch">
                        </div>
                    </div>
                    <div class="col">
                        <button style="margin-top: 15px;" type="submit" class="btn btn-primary mb-2">Поиск</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
@if ($mounth)
    <div class="col text-center alert alert-success" role="alert">
    <?= rusMounth($mounth);?>
    </div>
@endif
    </div>
<div class="row">
    <div class="col-lg-12">
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
    {{ $notes->links() }}
    <table class="table table-striped table-bordered">
        <caption>Список именинников</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Фотография</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
                <th scope="col">Должность</th>
                <th scope="col">Компания</th>
                <th scope="col">Дата рождения</th>
                @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
                <th scope="col">Действие</th>
                @endif
            </tr>
        </thead>
        <tbody>
    @foreach ($notes as $noteall)
            <tr>
                <th>
                    @if($noteall->photo !== null)
                    <img class="img-thumbnail h90" src="{{ asset($noteall->photo) }}">
                    @else
                    <img src="{{ asset('/img/nophoto.png') }}" class="figure-img img-fluid rounded img-thumbnail h90" alt='Фотографии нет'>
                    @endif
                </th>
                <th>{{ $noteall->nameF }}</th>
                <th>{{ $noteall->nameN }}</th>
                <th>{{ $noteall->nameOt }}</th>
                <th class="word-b">{{ $noteall->dolzh }}</th>
                <th class="word-b">{{ $noteall->work }}</th>
                @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
                <th>{{ mounthP(date('d-m-Y', strtotime($noteall->date))) }}</th>
                @else
                <th>{{ mounthP(date('d-m', strtotime($noteall->date))) }}</th>
                @endif
                @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
                <th>
                    <p><a href="{{ action('InputController@goPDF', ['id' => $noteall->id]) }}" class="btn btn-primary">
                        Просмотреть
                        </a></p>
                    <p><a href="{{ action('InputController@editOne', ['id' => $noteall->id]) }}" class="btn btn-primary">
                        Редактировать
                        </a></p>
                    <div class="spinner-border text-success" id="sp{{$noteall->id}}" style="display:none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div><p><a href="{{ action('InputController@sendmail', ['id' => $noteall->id]) }}" id="s{{$noteall->id}}" onclick='addName("s{{$noteall->id}}","sp{{$noteall->id}}")' class="btn btn-success">
                            <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true">
                            </span>
                        Отправить
                        </a></p>
                        <p><a href="{{ action('InputController@delOne', ['id' => $noteall->id]) }}" 
                              OnClick="return confirm('Подтвердите удаление элемента')" class="btn btn-danger">
                        Удалить
                        </a></p>
                </th>
                @endif
            </tr>
    @endforeach
        </tbody>
    </table>
    {{ $notes->links() }}
    
</div>
</div>
</div>
@endsection
