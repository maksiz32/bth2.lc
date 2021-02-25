@extends('layouts.app')
@section('title', 'Редактирование заявок за месяц')
@section('content')
@push('head')
<script>
    $(document).ready(function(){
        $('.btn-primary').on('click',function(){
            $(this).css('display','none');
        })
    });
</script>
@endpush
<div class="container-fluid top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <a href="{{action('CarController@allByMounth',['dateMain' => $car->setPrewMounth($dateMain)])}}" 
               class="btn btn-sm btn-primary">
            &lt;&lt;&nbsp;{{$car->getPrewMounthName($dateMain)}}
            </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php $year = explode("-",$dateMain);?>
            <span style="font-size: 1.5em">{{$car->getNameMounth($dateMain)." ".$year[2]." г."}}</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{action('CarController@allByMounth',['dateMain' => $car->setNextMounth($dateMain)])}}" 
               class="btn btn-sm btn-primary">
            {{$car->getNextMounthName($dateMain)}}&nbsp;&gt;&gt;
            </a>
            <table class="table table-sm mt-3 table-bordered">
                @foreach($mechanits as $mech)
                <thead class="thead-dark">
                    <tr>
                        <th colspan="6"><strong>
                            {{$mech->model.' - '.$mech->driver.' - '.$mech->number}}
                        </strong></th>
                    </tr>
                    <tr>
                        <th scope="col">Дата</th>
                        <th scope="col">Время</th>
                        <th scope="col">Куда/ Цель</th>
                        <th scope="col">Кто едет</th>
                        <th scope="col">Машина</th>
                        <th scope="col">Операции</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($books)>0)
                    @foreach($books as $book)
                    @if($book->avid == $mech->id)
                    <tr>
                        <!--<th>{{$loop->iteration}}</th>-->
                        <th>{{date('d', strtotime($book->date))." ".$car->mounthNameP($book->date)}}</th>
                        <th>{{'c '.$car->setTimeStart($book->time_start).' до '.$car->setTimeStart($book->time_start + $book->count_time)}}</th>
                        <th class="text-left">{{$book->target}}</th>
                        <th>{{$book->who}}</th>
                        <th class="text-left">{{$book->model.' :: '.$book->number.' :: '.$book->driver}}</th>
                        <th>
                            @if(RGSPortal::isAdmin(getenv('REMOTE_USER')) || 
                            RGSPortal::canDeleteBook(getenv('REMOTE_USER'), $book))
                            <a href="{{action('CarController@delete',['id' => $book->id])}}" 
                               class="btn btn-danger">Удалить</a>
                            @endif
                        </th>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection

