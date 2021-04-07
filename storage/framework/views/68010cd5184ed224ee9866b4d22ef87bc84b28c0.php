<?php $__env->startSection('title', "Подтверждение в AD"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <br/>
    <br/>
    <?php if(isset($message)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo e($message); ?>

    </div>
    <?php endif; ?>
    <a class="button-blue" href="<?php echo e(action('AdWorkController@adldapView')); ?>">
        Попробовать еще раз
    </a>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>