@extends('layouts.app')
@section('title', 'Подтверждение отправки')
@section('content')@push("head")
<script>
    $(document).ready(function() {
        $('#forclick').on('click', function(){
            $('#first').css('display', 'none');
            $('#second').css('display', 'block');
        });
    });
    function doPlus(id) {
        var inpNum = document.getElementById('inpNum'+id);
        var answer = parseInt(inpNum.value) + 1;
        let max = parseInt(document.getElementById('remain'+id).innerHTML);
        if (answer <= max) {
            inpNum.value = answer;
        } else {
            answer = answer - 1;
            alert('Нельзя выбрать больше остатка на складе '+max+"you: "+answer);
        }
    };
    function doMinus(id) {
        let answerM = parseInt(document.getElementById('inpNum'+id).value) - 1;
        let inpNum = document.getElementById('inpNum'+id);
        if (answerM >= 0) {
            inpNum.value = answerM;
        } 
    }
</script>
@endpush
<article class="container main_page orders">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
    {{ $orders->links() }}
    @endif
    <form action="{{action('OrderController@submitOrder')}}" method="post">
        Подтверждение отправки:
            {{ method_field('PUT') }}
            {{ csrf_field() }}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>IP-адрес</th>
                <th>Дата</th>
                <th>Подразделение</th>
                <th>Имя пользователя</th>
                <th>Техника</th>
                <th>Расходка</th>
                <th>Заказано</th>
                <th>Осталось</th>
                <th>Подтверждение</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    {{long2ip($order->real_ip)}}
                </td>
                <td>
                    {{$order->created}}
                </td>
                <td>
                    {{$order->firm}}
                </td>
                <td>
                    {{$order->user_name}}
                </td>
                <td>
                    {!! $order->tech !!}
                </td>
                <td @if($order->count <= 5) {{_('class=td-red')}}@endif>
                    {{$order->model}}
                </td>
                <td>
                    <input type="hidden" value="{{$order->order_id}}" name="ordId[]">
                    <input type="hidden" value="{{$order->id}}" name="remainId[]">
                    <input type="hidden" value="{{$order->tech_id}}" name="techId[]">
                    <input type="text" value="{{$order->count_m}}" id="inpNum{{$order->id}}" name="count[]">
                    <div>
                        <i class="bi bi-dash-square s500 orderMinus" 
                        onclick="doMinus({{$order->id}})"></i>
                        <i class="bi bi-plus-square orderPlus s500" 
                        onclick="doPlus({{$order->id}})"></i>
                    </div>
                </td>
                <td @if($order->count <= 5) {{_('class=td-red')}}@endif>
                    <span id="remain{{$order->id}}">{{ $order->count }}</span>
                </td>
                <td>
                    @if ($order->confirmed)
                        <i class="bi bi-check-square" style="color: cornflowerblue"></i>
                    @else
                        <i class="bi bi-x-square" style="color: red"></i>
                    @endif
                </td>
            </tr>
            @endforeach
            @if (!$nobutton)
            <tr class="bg-warning" id="forclick">
                <td class="success" colspan="9" style="text-align: center" id="first">
                    <button type="submit" class="btn btn-info btn-lg">Подтвердить</button>
                </td>
                <td class="success" colspan="9" style="text-align: center; display: none" id="second">
                    Отправляю
                </td>
            </tr>
        </tbody>
        @endif
    </table>
    </form>
    @if (RGSPortal::isAdmin(getenv('REMOTE_USER')))
    {{ $orders->links() }}
    @endif
</article>
@endsection

