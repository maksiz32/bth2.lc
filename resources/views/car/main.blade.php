@extends('layouts.app')
@section('title', 'Заказ автомобиля для поездки')
@section('content')
@push('head')
<script>
    $(document).ready(function() {
        $('#clickViewOrders').on('click', function(){
            $('#viewOrders .forShowHide').each(function(){
                $(this).css('display', 'block');
            });
            $(this).css('display', 'none');
            $('#clickNoViewOrders').css('display', 'block');
        });
        
        $('#clickNoViewOrders').on('click', function(){
            $('#viewOrders .forShowHide').each(function(){
                $(this).css('display', 'none');
            });
            $(this).css('display', 'none');
            $('#clickViewOrders').css('display', 'block');
        });
    });
</script>
@endpush
<div class="container-fluid top-110">
@if(!RGSPortal::canBookingCar(getenv('REMOTE_ADDR')))
    <div class="row">
        Для вашего подразделения данная услуга недоступна
    </div>
@else
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="row align-items-center mt-3">
        <div class="col-md-2 text-center">
            <a href="{{action('CarController@main',['dateMain' => $car->setPrewMounth($dateMain)])}}" 
               class="btn btn-sm btn-primary">
            &lt;&lt;&nbsp;{{$car->getPrewMounthName($dateMain)}}
            </a>
        </div>
        <div class="col-md-2 text-center">
            <?php $year = explode("-",$dateMain);?>
            <h4>{{$car->getNameMounth($dateMain)." ".$year[2]." г."}}</h4>
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">пн</th>
                        <th scope="col">вт</th>
                        <th scope="col">ср</th>
                        <th scope="col">чт</th>
                        <th scope="col">пт</th>
                        <th scope="col" style="background-color: red !important">сб</th>
                        <th scope="col" style="background-color: red !important">вс</th>
                    </tr>
                </thead>
                <tbody>
<?php $k=1;
    $countWeeks = ceil(($numFirstDay - 1 + $countDays) / 7);//Считаю количество недель
    for($i=0;$i<$countWeeks;$i++){?>
        <tr>
    <?php for($j=1;$j<=7;$j++){
        //Выделяю выходные дни
            if($i==0 && $numFirstDay > $j){?>
                <th scope="row" @if($j>5) style="background-color: lightgrey" @endif></th>
    <?php }else if($k <= $countDays){
            if($k<10) {
                $n = '0'.$k;
            } else {
                $n = $k;
            }
            $link = $n."-".$year[1]."-".$year[2];
            $dN = explode('-',date('d-m-Y'));
    ?>
                @if(count($arrDay) > 0 && in_array($n, $arrDay))
                <th class="alert-danger booking" scope="row">
                    {{-- Блок для текущей даты или позже --}}
                @if(date('Y-m-d',strtotime($link)) >= date('Y-m-d'))
                    <a href="{{action('CarController@inputBook', ['date' => $link])}}">
                    {{$k}}
                    </a>
                @else
                    {{$k}}
                @endif
                </th>
                @else
                {{--Выделяю выходные дни--}}
                <th class="booking" scope="row" 
                    @if($j>5) style="background-color: lightgrey" id="weekend" @endif>
                @if(date('Y-m-d', strtotime($n.'-'.$year[1].'-'.$year[2])) >= date('Y-m-d'))
                    <a href="{{action('CarController@inputBook', ['date' => $link])}}">
                    {{$k}}
                    </a>
                @else
                    {{$k}}
                @endif
                </th>
                @endif
        <?php $k++;
            } else {?>
                {{--Выделяю выходные дни--}}
                <th scope="row" @if($j>5) style="background-color: lightgrey" @endif></th>
            <?php }
        }?>
        </tr>
    <?php }?>
                </tbody>
            </table>
            @if(date('m', strtotime($dateMain)) != date('m'))
            <a class="btn btn-primary btn-sm mt-6" href="/car">
                Перейти на дату {{$car->mounthP(date('d-m-Y'))}}
            </a>
            @endif
            <div style="margin-top: 60px">
                <a href="/carMounth">
                &DoubleRightArrow; Просмотр таблицы по месяцам &DoubleLeftArrow;
                </a>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <a href="{{action('CarController@main',['dateMain' => $car->setNextMounth($dateMain)])}}" 
               class="btn btn-sm btn-primary">
            {{$car->getNextMounthName($dateMain)}}&nbsp;&gt;&gt;
            </a>
        </div>
        <div class="col-md-6" id="viewOrders">
        @if(count($bookings)>0)
        <?php $tmp = false;?>
        @foreach($bookings as $book)
        @if(date('Y-m-d',strtotime($book->date)) >= date('Y-m-d'))
        {{--По умолчанию отображаются заявки больше или равные текущей дате--}}
            <div class="shadow alert-success mb-2 pl-1 pr-1 rounded" 
                 style="border: 1px solid grey" role="alert">
                {{date('d.m', strtotime($book->date)).
                ': '}}<strong>{{$book->who}}</strong>{{' (+7'.$book->phone.')'.' c '.
                $car->setTimeStart($book->time_start).' до '.
                $car->setTimeStart($book->time_start + $book->count_time)}}
                <br>
                {{' в (с целью) '}}<strong>{{$book->target}}</strong>
                {{' '.$book->model.' :: '.$book->number.' :: '.$book->driver.
                ' (+7'.$book->phone_driver.') '}}
            </div>
        @else
        <?php $tmp = true;?>
        {{--Заявки ранее текущей даты, скрыты для отображения по кнопке--}}
            <div class="forShowHide shadow alert-primary mb-2 pl-1 pr-1 rounded text-muted" 
                 style="border: 1px solid grey; display: none" role="alert">
                {{date('d.m', strtotime($book->date)).
                ': '}}<strong>{{$book->who}}</strong>{{' (+7'.$book->phone.')'.' c '.
                $car->setTimeStart($book->time_start).' до '.
                $car->setTimeStart($book->time_start + $book->count_time)}}
                <br>
                {{' в (с целью) '}}<strong>{{$book->target}}</strong>
                {{' '.$book->model.' :: '.$book->number.' :: '.$book->driver.
                ' (+7'.$book->phone_driver.') '}}
            </div>
        @endif
        @endforeach
        <?php if ($tmp){?>
        <div class="btn btn-primary btn-block btn-sm" id="clickViewOrders">
            Показать все заявки текущего месяца
        </div>
        <div class="btn btn-primary btn-block btn-sm" id="clickNoViewOrders" style="display: none">
            Скрыть прошедшие заявки
        </div>
        <?php }?>
        @else
        Нет заявок в этом месяце
        @endif
        </div>
    </div>
@endif
</div>
@endsection

