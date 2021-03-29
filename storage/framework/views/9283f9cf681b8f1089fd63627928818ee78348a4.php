<?php $__env->startSection('title', 'Заказ автомобиля для поездки'); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('head'); ?>
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
<?php $__env->stopPush(); ?>
<div class="container-fluid top-110">
<?php if(!RGSPortal::canBookingCar(getenv('REMOTE_ADDR'))): ?>
    <div class="row">
        Для вашего подразделения данная услуга недоступна
    </div>
<?php else: ?>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <div class="row align-items-center mt-3">
        <div class="col-md-2 text-center">
            <a href="<?php echo e(action('CarController@main',['dateMain' => $car->setPrewMounth($dateMain)])); ?>" 
               class="btn btn-sm btn-primary">
            &lt;&lt;&nbsp;<?php echo e($car->getPrewMounthName($dateMain)); ?>

            </a>
        </div>
        <div class="col-md-2 text-center">
            <?php $year = explode("-",$dateMain);?>
            <h4><?php echo e($car->getNameMounth($dateMain)." ".$year[2]." г."); ?></h4>
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
                <th scope="row" <?php if($j>5): ?> style="background-color: lightgrey" <?php endif; ?>></th>
    <?php }else if($k <= $countDays){
            if($k<10) {
                $n = '0'.$k;
            } else {
                $n = $k;
            }
            $link = $n."-".$year[1]."-".$year[2];
            $dN = explode('-',date('d-m-Y'));
    ?>
                <?php if(count($arrDay) > 0 && in_array($n, $arrDay)): ?>
                <th class="alert-danger booking" scope="row">
                    
                <?php if(date('Y-m-d',strtotime($link)) >= date('Y-m-d')): ?>
                    <a href="<?php echo e(action('CarController@inputBook', ['date' => $link])); ?>">
                    <?php echo e($k); ?>

                    </a>
                <?php else: ?>
                    <?php echo e($k); ?>

                <?php endif; ?>
                </th>
                <?php else: ?>
                
                <th class="booking" scope="row" 
                    <?php if($j>5): ?> style="background-color: lightgrey" id="weekend" <?php endif; ?>>
                <?php if(date('Y-m-d', strtotime($n.'-'.$year[1].'-'.$year[2])) >= date('Y-m-d')): ?>
                    <a href="<?php echo e(action('CarController@inputBook', ['date' => $link])); ?>">
                    <?php echo e($k); ?>

                    </a>
                <?php else: ?>
                    <?php echo e($k); ?>

                <?php endif; ?>
                </th>
                <?php endif; ?>
        <?php $k++;
            } else {?>
                
                <th scope="row" <?php if($j>5): ?> style="background-color: lightgrey" <?php endif; ?>></th>
            <?php }
        }?>
        </tr>
    <?php }?>
                </tbody>
            </table>
            <?php if(date('m', strtotime($dateMain)) != date('m')): ?>
            <a class="btn btn-primary btn-sm mt-6" href="/car">
                Перейти на дату <?php echo e($car->mounthP(date('d-m-Y'))); ?>

            </a>
            <?php endif; ?>
            <div style="margin-top: 60px">
                <a href="/carMounth">
                &DoubleRightArrow; Просмотр таблицы по месяцам &DoubleLeftArrow;
                </a>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <a href="<?php echo e(action('CarController@main',['dateMain' => $car->setNextMounth($dateMain)])); ?>" 
               class="btn btn-sm btn-primary">
            <?php echo e($car->getNextMounthName($dateMain)); ?>&nbsp;&gt;&gt;
            </a>
        </div>
        <div class="col-md-6" id="viewOrders">
        <?php if(count($bookings)>0): ?>
        <?php $tmp = false;?>
        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(date('Y-m-d',strtotime($book->date)) >= date('Y-m-d')): ?>
        
            <div class="shadow alert-success mb-2 pl-1 pr-1 rounded" 
                 style="border: 1px solid grey" role="alert">
                <?php echo e(date('d.m', strtotime($book->date)).
                ': '); ?><strong><?php echo e($book->who); ?></strong><?php echo e(' (+7'.$book->phone.')'.' c '.
                $car->setTimeStart($book->time_start).' до '.
                $car->setTimeStart($book->time_start + $book->count_time)); ?>

                <br>
                <?php echo e(' в (с целью) '); ?><strong><?php echo e($book->target); ?></strong>
                <?php echo e(' '.$book->model.' :: '.$book->number.' :: '.$book->driver.
                ' (+7'.$book->phone_driver.') '); ?>

            </div>
        <?php else: ?>
        <?php $tmp = true;?>
        
            <div class="forShowHide shadow alert-primary mb-2 pl-1 pr-1 rounded text-muted" 
                 style="border: 1px solid grey; display: none" role="alert">
                <?php echo e(date('d.m', strtotime($book->date)).
                ': '); ?><strong><?php echo e($book->who); ?></strong><?php echo e(' (+7'.$book->phone.')'.' c '.
                $car->setTimeStart($book->time_start).' до '.
                $car->setTimeStart($book->time_start + $book->count_time)); ?>

                <br>
                <?php echo e(' в (с целью) '); ?><strong><?php echo e($book->target); ?></strong>
                <?php echo e(' '.$book->model.' :: '.$book->number.' :: '.$book->driver.
                ' (+7'.$book->phone_driver.') '); ?>

            </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if ($tmp){?>
        <div class="btn btn-primary btn-block btn-sm" id="clickViewOrders">
            Показать все заявки текущего месяца
        </div>
        <div class="btn btn-primary btn-block btn-sm" id="clickNoViewOrders" style="display: none">
            Скрыть прошедшие заявки
        </div>
        <?php }?>
        <?php else: ?>
        Нет заявок в этом месяце
        <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>