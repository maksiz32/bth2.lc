<?php $__env->startSection('title', "Техническая страница"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <p>
    <h2>Запрошенная страница не надена.</h2>
    </p>
    <p>
    <h3>Нажмите кнопку назад и попробуйте еще раз позднее.</h3>
    </p>
    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary">Назад</a>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>