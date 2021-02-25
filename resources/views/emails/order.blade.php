<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Заказ картриджей от {{$order[0]['firm']}}</title>
</head>
<body>
    <article>
        <div class="container">
            <div class="text-center">
                Заказ от <strong>{{$order[0]['firm']}}</strong> с адреса <strong>{{long2ip($order[0]['real_ip'])}}</strong>:
                Отправлено от {{ $userRealName }}
            </div>
            <ul>
                @if(isset($order[0]['model']))
                @foreach($order as $ord)
                <li>Картридж <b>{{$ord['model']}}</b> для <u>{{$ord['tech']}}</u> в количестве - <b>{{$ord['count_m']}} шт.</b></li>
                @endforeach
                @endif
            </ul>
            <p>
                Дополнительно:
                @foreach($order as $ord)
                <b>{{$ord['others']}}</b>
                @endforeach
            </p>
        </div>
    </article>
</body>
</html>
