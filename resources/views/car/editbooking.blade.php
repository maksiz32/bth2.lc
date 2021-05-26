@extends('layouts.app')
@section('title', "Заказать автомобиль на дату ".$dateBook)
@section('content')
@push("head")
    <!-- <script src="{{ asset('/js/jquery-ui.min.js') }}"></script> -->
<script>
    $(document).ready(function(){
        $('#subm').css('display', 'block');
        $('#no').attr('class', 'btn btn-danger');
        $('#yes').attr('class', 'btn btn-light');
        $('#regions').val('0');
        
        $('#yes').on('click',function(){
            $('#yes').attr('class', 'btn btn-primary');
            $('#no').attr('class', 'btn btn-light');
            $('#regions').val('');
            $('#regions').val('1');
        });
        $('#no').on('click',function(){
            $('#yes').attr('class', 'btn btn-light');
            $('#no').attr('class', 'btn btn-danger');
            $('#regions').val('');
            $('#regions').val('0');
        });
                
        $('#subm button').on('click',function(){
            $('#subm').css('display','none');
        });
    });
</script>
@endpush
<div class="container top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-warning" role="alert">
            {{$message}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ action('CarController@saveBook') }}" method="post" id="carForm">
        <div class="form-row">
            <h2 class="form-group col-12">
                Забронировать на дату: 
                <span class="badge badge-primary">
                    {{date('d-m-Y', strtotime($dateBook))}}
                </span>
            </h2>
            {{ csrf_field() }}
            <input type="hidden" name="who" value="{{$name}}">
            <input type="hidden" name="ip" value="{{getenv('REMOTE_ADDR')}}">
            <input type="hidden" name="date" value="{{$dateBook}}">
            <div class="form-group col-12 carcard">
                <h3>Выберите машину:</h3>
                <div class="carcard-items">
                    @foreach($avtos as $avto)
                    <?php $path = asset('/img/car/'.$avto->carphoto)?>
                    <div class="carcard-items-unit" style="background-image: url('<?=$path?>')" 
                            app-data="{{$avto->id}}">
                        <span class="carcard-items-unit__text" app-data="{{$avto->id}}" 
                                name="titleCard">{{$avto->driver}}</span>
                        <span class="carcard-items-unit__text check-hide" name="hideText{{$avto->id}}">
                            {{$avto->model}}
                        </span>
                        <span class="carcard-items-unit__text check-hide" name="hideText{{$avto->id}}">
                            {{$avto->number}}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div id="secondForm" class="form-group col-12 secondForm">
                <div class="form-group col-md-6">
                    <?php
                    $times = [
                        1 => '09:00',
                        2 => '10:00',
                        3 => '11:00',
                        4 => '12:00',
                        5 => '14:00',
                        6 => '15:00',
                        7 => '16:00',
                        8 => '17:00',
                    ];
                    ?>
                    <label for="time_start" class="control-label">Время начала:</label>
                    <select name="time_start">
                        @foreach($times as $key=>$time)
                        
                        <option value="{{$key}}">
                            {{$time}}
                        </option>
                        @if($key==4)
                        <option disabled value="">
                            ===
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="count_time" class="control-label">Продолжительность (в часах):</label>
                    <select name="count_time">
                        <?php
                        for($i=1;$i<9;$i++){
                        ?>
                        <option value="{{$i}}">
                            @if($i==8)
                                На весь день
                            @else
                            {{$i." ч."}}
                            @endif
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-9">
                    <label for="target" class="control-label">Место назначения и цель поездки:</label>
                    <input type="text" class="form-control" name="target" value="{{ old('target') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="phone" class="control-label small">Ваш телефон (10 цифр - 910...):</label>
                    <input type="text" class="form-control" name="phone" 
                        value=@if(isset($phoneMe))"{{old('phone',$phoneMe->phone)}}"@else"{{old('phone')}}"@endif required>
                </div>
                <div class="mb-1">Сообщить о поездке во все районы?</div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <div class="btn btn-danger" id="no">НЕТ</div>
                    <div class="btn btn-light" id="yes">ДА</div>
                    <input type="text" id="regions" name="regions" style="visibility: hidden">
                </div>
            </div>
        </div>
    </form>
    @if(isset($bookings) && count($bookings)>0)
    <hr class="mt-6">
    <h3>На этот день забронировано:</h3>
    @foreach($bookings as $book)
    <div class="shadow alert-success mb-2 pl-1 pr-1 rounded"
         style="border: 1px solid grey" role="alert">
        {{' c '.$car->setTimeStart($book->time_start).' до '.
        $car->setTimeStart($book->time_start + $book->count_time)}}
        <strong>{{$book->who}}</strong>{{' (+7'.$book->phone.') '.
        $book->model.' :: '.$book->number.' :: '.$book->driver.
        ' (+7'.$book->phone_driver.') '}}
    </div>
    @endforeach
    @endif
</div>
<script>
    const card = document.getElementsByClassName('carcard-items-unit');
    const form = document.getElementById('carForm')
    const titleCard = document.getElementsByName('titleCard')
        for(let i = 0; i < titleCard; i++) {
            titleCard[i].addEventListener('mouseover', function(e) {
                const id = e.target.getAttribute('app-data')
                const textEtc = document.getElementsByName('hideText'+id)
                for(let j = 0; j < textEtc.length; j++) {
                    textEtc[j].classList.remove('check-hide')
                    textEtc[j].addEventListener('mouseover', function() {
                        for(let k = 0; k < textEtc.length; k++) {
                            textEtc[k].classList.remove('check-hide');
                        }
                    })
                    textEtc[j].addEventListener('mouseout', function(elem) {
                        for(let elem in textEtc) {
                            textEtc[elem].classList.add('check-hide');
                        }
                    })
                }
            })
        }
    for(let i = 0; i < card.length; i++) {
        card[i].addEventListener('mouseover', function(el) {
            const id = el.target.getAttribute('app-data');
            const textEtc = document.getElementsByName('hideText'+id)
            for(let j = 0; j < textEtc.length; j++) {
                textEtc[j].classList.remove('check-hide')
                textEtc[j].addEventListener('mouseover', function() {
                    for(let k = 0; k < textEtc.length; k++) {
                        textEtc[k].classList.remove('check-hide');
                    }
                })
                textEtc[j].addEventListener('mouseout', function() {
                    for(let k = 0; k < textEtc.length; k++) {
                        textEtc[k].classList.add('check-hide');
                    }
                })
            }
        })
        card[i].addEventListener('mouseout', function(el) {
            const id = el.target.getAttribute('app-data');
            const textEtc = document.getElementsByName('hideText'+id)
            for(let j = 0; j < textEtc.length; j++) {
                textEtc[j].classList.add('check-hide')
            }
        })
        card[i].addEventListener('click', function(ev) {
            validSecondView()
            if (el = document.getElementById('idAvto')) {
                form.removeChild(el)
                ev.target.classList.remove('carard-items-unit__checked')
                ev.target.removeAttribute('id')
                if (lastCar = document.getElementById('checkCar')) {
                    lastCar.classList.remove('carard-items-unit__checked')
                    lastCar.removeAttribute('id')
                    checkCar(ev)
                }
            } else {
                checkCar(ev)
            }
        })
    }
    function checkCar(ev) {
        const id = ev.target.getAttribute('app-data');
        const el = document.createElement('input')
        el.setAttribute('type', 'hidden')
        el.setAttribute('name', 'id_avto')
        el.setAttribute('id', 'idAvto')
        el.value = id
        form.appendChild(el);
        ev.target.classList.add('carard-items-unit__checked')
        ev.target.setAttribute('id', 'checkCar')
        const secondForm = document.getElementById('secondForm')
            secondForm.classList.remove('secondForm')
        secondForm.setAttribute('app-view', '1')
    }
    function validSecondView() {
        const secondForm = document.getElementById('secondForm')
        const visible = secondForm.getAttribute('app-view')
        if (visible) {
            secondForm.classList.add('secondForm')
            secondForm.removeAttribute('app-view')
        }
    }
</script>
@endsection
