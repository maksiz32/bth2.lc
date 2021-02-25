@extends('layouts.app')
@section('title', "Все подразделения Филиала")
@section('content')
<article class="container-fluid main_page top-110">
    @if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif
    @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
    <div class="row mar15 alert alert-danger" role="alert">
        <div class="col-6 text-center">
            <a href="/firms/create" class="btn btn-primary">
                Создать подразделение
            </a>
        </div>
        @if(Route::currentRouteAction() == 'App\Http\Controllers\FirmController@index')
        <div class="col-6 text-center">
            <a href="/firms/no-all" class="btn btn-danger">
                Убрать закрытые
            </a>
        </div>
        @else
        <div class="col-6 text-center">
            <a href="/firms" class="btn btn-primary">
                Отобразить все
            </a>
        </div>
        @endif
    </div>
    @else
    <div class="row mar15 alert alert-danger" role="alert">
        @if(Route::currentRouteAction() == 'App\Http\Controllers\FirmController@index')
        <div class="col-12 text-center">
            <a href="/firms/all" class="btn btn-primary">
                Отобразить все
            </a>
        </div>
        @else
        <div class="col-12 text-center">
            <a href="/firms" class="btn btn-danger">
                Убрать закрытые
            </a>
        </div>
        @endif
    </div>
    @endif
    <table class="table table-striped">
        <thead class="thead-dark text-center">
            <tr>
                @if($stat)
                <th scope="col">Статус</th>
                @endif
                <th scope="col">Название</th>
                <th scope="col">ФИО НСО</th>
                <th scope="col">Код СКК</th>
                <th scope="col">Адрес</th>
                <th scope="col">Телефон</th>
                @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
                <th scope="col">Начальный ip-адрес</th>
                <th scope="col">Конечный ip-адрес</th>
                <th scope="col">Имя латиница</th>
                <th scope="col">Операции</th>
                @endif
            </tr>
        </thead>
        <tbody>
            
            @foreach($firms as $firm)
            <tr <?php if(!$firm->isblock) {?>
                class="text-danger"
                <?php } ?>>
                @if($stat)
                <th scope="row">
                @if(!$firm->isblock)
                ЗАКРЫТО
                @endif
                </th>
                @endif
                <th scope="row">{{ $firm->name }}</th>
                <th>{{ $firm->famNSO." ".$fName = $firm->nameNSO." ".$fOtch = $firm->otchNSO }}</th>
                <?php /*
                <?php $initNSO = mb_substr($fName, 0, 1).".".mb_substr($fOtch, 0, 1).".";?>
                <th>{{ $initNSO }}</th>
                */?>
                <th>{{ $firm->skk }}</th>
                <th><address>{{ $firm->addr }}</address></th>
                <th>{{ $firm->tel }}</th>
                @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
                <th class="lead">{{ long2ip($firm->ipStart) }}</th>
                <th class="lead">{{ long2ip($firm->ipEnd) }}</th>
                <th class="lead">{{ $firm->nameEng }}</th>
                <th>
                    <p><a href="{{ action('FirmController@create', ['id' => $firm->id]) }}" class="btn btn-primary">
                        Редактировать
                        </a></p>
                        <form action="{{ action('FirmController@destroy', ['id' => $firm->id]) }}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger" 
                                    OnClick="return confirm('Подтвердите удаление элемента')" 
                                    type="submit">Удалить</button>
                        </form>
                </th>
                @endif
            </tr>
            @endforeach
            
            </tbody>
    </table>
      
</article>
@endsection
