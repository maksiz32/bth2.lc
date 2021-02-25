<?php $__env->startSection('title', "IP-адрес"); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="panel panel-primary alert alert-success">
    <div class="row mar15 alert alert-info" role="alert">
        <div class="col-12 text-left">
            <h3 class="m-5">
                <strong>Имя учетной записи (в Домене): </strong>
                <span class="bg-light"><?php echo e(getenv('REMOTE_USER')); ?></span>
                &nbsp;
                <span class="bg-light">@rgs.ru</span>
            </h3>
            <h3 class="m-5">
                <strong>Ваш ip-адрес: </strong>
                <span class="bg-light"><?php echo e($ip); ?></span>
            </h3>
            <h3 class="m-5">
                <strong>Имя компьютера (ПК): </strong>
                <span class="bg-light"><?php echo e(gethostbyaddr($ip)); ?></span>
            </h3>
        </div>
    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>