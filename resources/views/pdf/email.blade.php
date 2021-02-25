<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .top-red {
            display: block;
            border-top: 10px solid #b21f2d;
            border-bottom: 2px dotted goldenrod;
            height: 100px;
            color: #b21f2d;
            font-size: 4.5em;
            font-weight: bold;
        }
        .m-100 {
            margin-top: 0;
        }
        table {
            text-align: left;
        }
        .h200 {
            height: 200px;
        }
        .w40 {
            width: 40%;
        }
        .text-red {
            color: red;
            font-weight: bold;
        }
    </style>
    <title>Поздравляем с Днем Рождения!</title>
    <?php
    require_once (public_path('script/month.php'));
    ?>
</head>
<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 top-red bot-yel-dott">
                    РОСГОССТРАХ
                </div>
            </div>
    <table class="table table-borderless">
        <tbody>
            <tr>
                <th colspan="2">
                    <p>Коллеги, доброе утро!</p>
                    {{ $monthM->day }} <?php rusMounthV($monthM->month);?> свой день рождения отмечает:
                </th>
            </tr>
            <tr>
                <th scope="row" class="w40">
                    @if($dataB->photo !== null)
                    <img class="h200 figure-img img-fluid rounded img-thumbnail" src="{{ $message->embed('c:\\openserver\\domains\\bth2.lc\\public\\'.$dataB->photo) }}">
                    @else
                    <img src="{{ $message->embed('c:\openserver\domains\bth2.lc\public\img\nophoto.png') }}" class="figure-img img-fluid rounded h200" alt='Фотографии нет'>
                    @endif</th>
                <th>
                    <p>{{ $dataB->nameF }} {{ $dataB->nameN }} {{ $dataB->nameOt }}</p>
                    <br/>
                    <br/>
                    <p>
                    {{ ucfirst($dataB->dolzh) }}
                    </p>
                    {{ $dataB->work }}
                </th>
            </tr>
            <tr>
                <th colspan="2" class="text-red">
                    {{ $dataB->nameN }} {{ $dataB->nameOt }}!
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <p>
                        От всего огромного коллектива РОСГОССТРАХ поздравляем Вас с Днем рождения!
                    </p>
                    <p>
                        Желаем Вам ЧЕСТНЫХ отношений, РАЗВИТИЯ вместе с компанией, НЕРАВНОДУШНЫХ и надежных друзей и партнеров, ТРУДОЛЮБИЯ, КОМАНДНОЙ поддержки и заслуженного УВАЖЕНИЯ! 
                    </p>
                    <p>
                        Пусть Вам и Вашим близким всегда сопутствуют крепкое здоровье, благополучие и счастье!
                    </p>
<br/>
<br/>
Коллектив ПАО СК «РОСГОССТРАХ»
в Брянской области

                    </p>
                </th>
            </tr>
        </tbody>
    </table>
        </div>
    </section>
</body>
</html>
