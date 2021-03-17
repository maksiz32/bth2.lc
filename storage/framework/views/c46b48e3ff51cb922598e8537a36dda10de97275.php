<?php $__env->startSection('title', "Все отчеты в разделе Заказ расходных материалов"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo e(url('/byfirm')); ?>" class="stretched-link">
                <div class="shadow alert alert-success rounded" role="alert" id="link">
                    <p>
                        <strong>
                            По отделам
                        </strong>
                    </p>
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <a href="<?php echo e(url('/bydate')); ?>" class="stretched-link">
                <div class="shadow alert alert-success rounded" role="alert" id="link">
                    <p>
                        <strong>
                            По дате
                        </strong>
                    </p>
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <a href="<?php echo e(url('/bytech')); ?>" class="stretched-link">
                <div class="shadow alert alert-success rounded" role="alert" id="link">
                    <p>
                        <strong>
                            По технике
                        </strong>
                    </p>
                </div>
            </a>
        </div>
    </div>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>