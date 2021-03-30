<?php $__env->startSection('title', "Заказать автомобиль на дату ".$dateBook); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
    <script src="<?php echo e(asset('/js/jquery-ui.min.js')); ?>"></script>
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
<?php $__env->stopPush(); ?>
<div class="container top-130">
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($message = Session::get('danger')): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo e($message); ?>

        </div>
    <?php endif; ?>
    <?php if(count($errors)>0): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(action('CarController@saveBook')); ?>" method="post">
    <div class="form-row">
        <div class="form-group col-12">
            Забронировать на дату: 
            <span class="badge badge-primary">
                <?php echo e(date('d-m-Y', strtotime($dateBook))); ?>

            </span>
        </div>
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="who" value="<?php echo e($name); ?>">
        <input type="hidden" name="ip" value="<?php echo e(getenv('REMOTE_ADDR')); ?>">
        <input type="hidden" name="date" value="<?php echo e($dateBook); ?>">
            <div class="form-group col-12">
                <label for="id_avto" class="control-label">Выбрать машину:</label>
                <select name="id_avto">
                    <?php $__currentLoopData = $avtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option class="small" value="<?php echo e($avto->id); ?>">
                        <?php echo e($avto->driver." ".$avto->model." ".$avto->number); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
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
                    <?php $__currentLoopData = $times; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <option value="<?php echo e($key); ?>">
                        <?php echo e($time); ?>

                    </option>
                    <?php if($key==4): ?>
                    <option disabled value="">
                        ===
                    </option>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="count_time" class="control-label">Продолжительность (в часах):</label>
                <select name="count_time">
                    <?php
                    for($i=1;$i<9;$i++){
                    ?>
                    <option value="<?php echo e($i); ?>">
                        <?php if($i==8): ?>
                            На весь день
                        <?php else: ?>
                        <?php echo e($i." ч."); ?>

                        <?php endif; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-9">
                <label for="target" class="control-label">Место назначения и цель поездки:</label>
                <input type="text" class="form-control" name="target" value="<?php echo e(old('target')); ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="phone" class="control-label small">Ваш телефон (10 цифр - 910...):</label>
                <input type="text" class="form-control" name="phone" 
                       value=<?php if(isset($phoneMe)): ?>"<?php echo e(old('phone',$phoneMe->phone)); ?>"<?php else: ?>"<?php echo e(old('phone')); ?>"<?php endif; ?> required>
            </div>
    </div>
            <div class="mb-1">Сообщить о поездке во все районы?</div>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <div class="btn btn-danger" id="no">НЕТ</div>
            <div class="btn btn-light" id="yes">ДА</div>
            <input type="text" id="regions" name="regions" style="visibility: hidden">
        </div>
        <div class="btn-group mt-5" id="subm">
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </div>
    </form>
    <?php if(isset($bookings) && count($bookings)>0): ?>
    <hr class="mt-6">
    <h3>На этот день забронировано:</h3>
    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="shadow alert-success mb-2 pl-1 pr-1 rounded"
         style="border: 1px solid grey" role="alert">
        <?php echo e(' c '.$car->setTimeStart($book->time_start).' до '.
        $car->setTimeStart($book->time_start + $book->count_time)); ?>

        <strong><?php echo e($book->who); ?></strong><?php echo e(' (+7'.$book->phone.') '.
        $book->model.' :: '.$book->number.' :: '.$book->driver.
        ' (+7'.$book->phone_driver.') '); ?>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>