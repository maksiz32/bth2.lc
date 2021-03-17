<?php $__env->startSection('title', "По подразделению"); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
<?php if($name): ?>
    <div class="col-12 text-center alert alert-success" role="alert">
    <?php echo e($name); ?>

    </div>
<?php endif; ?>
    <div class="col-lg-12">
    <table class="table table-striped table-bordered">
        <caption>Количество заказанных расходников</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Картридж</th>
                <th scope="col">Количество</th>
                <th scope="col">Дополнительно</th>
                <th scope="col">Дата</th>
                <th scope="col">Отдел</th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th><?php echo e($rep->model); ?></th>
                <th><?php echo e($rep->count_m); ?></th>
                <th><?php if(isset($rep->others)): ?><?php echo e($rep->others); ?><?php endif; ?></th>
                <th><?php echo e(date('d-m-Y', strtotime($rep->created))); ?></th>
                <th><?php echo e($rep->firm); ?></th>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
	<a class="btn btn-primary" href="javascript:history.go('-1');">
            <div id="back">
                <b>Назад</b>
            </div>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>