<?php $__env->startSection('title', "Редактирование фото"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <?php if($message = Session::get('message')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo e(Session::get('message')); ?>

    </div>
    <?php endif; ?>

    <form action="<?php echo e(action('AdWorkController@adModify')); ?>" method="post">
        <div class="row">
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="ldapuser" value="<?php echo e(old('ldapuser', $ldapuser)); ?>">
            <input type="hidden" name="ldappass" value="<?php echo e(old('ldappass', $ldappass)); ?>">
            <input type="hidden" name="companyDN" value="<?php echo e(old('companyDN', $companyDN)); ?>">
        </div>
<?php
$i = 0;
?>
<?php $__currentLoopData = $ouPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <input type="hidden" id="dn3-<?php echo e($i); ?>" value="<?php echo e($pers['dn']); ?>">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="4">
                        <strong>
                            <?php echo e($pers['name'][0]); ?>

                        </strong>
                        <?php echo e((isset($pers['title'][0]))?" - ".$pers['title'][0]:''); ?>

                    </td>
                </tr>
            </table>
<?php
    $i++;
?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
            </div>
        </div>
    </form>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>