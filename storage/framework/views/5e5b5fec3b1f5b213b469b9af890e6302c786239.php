<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Styles -->
    <link href="<?php echo e(asset('/css/bootstrap.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/bootstrap-grid.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/bootstrap-reboot.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/open-iconic-bootstrap.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/app.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('/js/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/bootstrap.bundle.js')); ?>"></script>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .top-red {
            display: block;
            border-top: 10px solid #b21f2d;
            border-bottom: 2px dotted goldenrod;
            height: 100px;
            color: #b21f2d;
            font-size: 3em;
            font-weight: bold;
        }
        table {
            text-align: left;
        }
        .w40 {
            width: 40%;
        }
        .h200 {
            height: 200px;
        }
        .f-PDF {
            width: 136px !important;
            height: 100px;
        }
        #PDF {
            width: 136px !important;
            height: 100px;
        }
        .text-red {
            color: red;
            font-weight: bold;
            font-size: 1.5em;
        }
    </style>
    <title>Поздравляем с Днем Рождения!</title>
    <?php
    require_once (public_path('script/month.php'));
    ?>
</head>
<body>
    <section>
        <div class="container-fluid">
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
                    <?php echo e($monthM->day); ?> <?php rusMounthV($monthM->month);?> свой день рождения отмечает:
                </th>
            </tr>
            <tr>
                <th scope="row" class="w40">
                    <?php if($dataB->photo !== null): ?>
                    <img class="h200" src="<?php echo e('c:\\openserver\\domains\\bth2.lc\\public\\'.$dataB->photo); ?>">
                    <?php else: ?>
                    <img src="<?php echo e('c:\openserver\domains\bth2.lc\public\img\nophoto.png'); ?>" class="h200" alt='Фотографии нет'>
                    <?php endif; ?></th>
                <th>
                    <p><?php echo e($dataB->nameF); ?> <?php echo e($dataB->nameN); ?> <?php echo e($dataB->nameOt); ?></p>
                    <br/>
                    <br/>
                    <p>
                    <?php echo e(ucfirst($dataB->dolzh)); ?>

                    </p>
                    <?php echo e($dataB->work); ?>

                </th>
            </tr>
            <tr>
                <th colspan="2" class="text-red">
                    <?php echo e($dataB->nameN); ?> <?php echo e($dataB->nameOt); ?>!
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
