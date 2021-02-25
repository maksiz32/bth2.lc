<?php $__env->startSection('title', 'Редактирование заявок за месяц'); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('head'); ?>
<script>
    $(document).ready(function(){
        $('.btn-primary').on('click',function(){
            $(this).css('display','none');
        })
    });
</script>
<?php $__env->stopPush(); ?>
<div class="container-fluid top-130">
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <a href="<?php echo e(action('CarController@allByMounth',['dateMain' => $car->setPrewMounth($dateMain)])); ?>" 
               class="btn btn-sm btn-primary">
            &lt;&lt;&nbsp;<?php echo e($car->getPrewMounthName($dateMain)); ?>

            </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php $year = explode("-",$dateMain);?>
            <span style="font-size: 1.5em"><?php echo e($car->getNameMounth($dateMain)." ".$year[2]." г."); ?></span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo e(action('CarController@allByMounth',['dateMain' => $car->setNextMounth($dateMain)])); ?>" 
               class="btn btn-sm btn-primary">
            <?php echo e($car->getNextMounthName($dateMain)); ?>&nbsp;&gt;&gt;
            </a>
            <table class="table table-sm mt-3 table-bordered">
                <?php $__currentLoopData = $mechanits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <thead class="thead-dark">
                    <tr>
                        <th colspan="6"><strong>
                            <?php echo e($mech->model.' - '.$mech->driver.' - '.$mech->number); ?>

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
                    <?php if(count($books)>0): ?>
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($book->avid == $mech->id): ?>
                    <tr>
                        <!--<th><?php echo e($loop->iteration); ?></th>-->
                        <th><?php echo e(date('d', strtotime($book->date))." ".$car->mounthNameP($book->date)); ?></th>
                        <th><?php echo e('c '.$car->setTimeStart($book->time_start).' до '.$car->setTimeStart($book->time_start + $book->count_time)); ?></th>
                        <th class="text-left"><?php echo e($book->target); ?></th>
                        <th><?php echo e($book->who); ?></th>
                        <th class="text-left"><?php echo e($book->model.' :: '.$book->number.' :: '.$book->driver); ?></th>
                        <th>
                            <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER')) || 
                            RGSPortal::canDeleteBook(getenv('REMOTE_USER'), $book)): ?>
                            <a href="<?php echo e(action('CarController@delete',['id' => $book->id])); ?>" 
                               class="btn btn-danger">Удалить</a>
                            <?php endif; ?>
                        </th>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>