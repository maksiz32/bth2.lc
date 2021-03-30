<?php $__env->startSection('title', 'Все ОК!'); ?>
<?php $__env->startSection('content'); ?>
<article class="container h110">
    <div class="row">
        <div class="col-12">
    <?php if(isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <strong>
                <?php echo e($success); ?>

                </strong>
                <br/>
                <ul>
                    <?php if(isset($order[0]['model'])): ?>
                    <?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>Картридж <b><?php echo e($ord['model']); ?></b> для <u><?php echo e($ord['tech']); ?></u> в количестве - <b><?php echo e($ord['count_m']); ?> шт.</b></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
                <p>
                    Дополнительно:
                    <?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <b><?php echo e($ord['others']); ?></b>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
            </div>
    <?php endif; ?>
            <?php if($message = Session::get('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo e(Session::get('error')); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>