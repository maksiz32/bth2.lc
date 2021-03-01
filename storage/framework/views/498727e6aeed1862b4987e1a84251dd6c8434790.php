<?php $__env->startSection('title', 'Ввод остатков'); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Модель</th>
                <th>Картридж</th>
                <th>Категория</th>
                <th>Остатки</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $teches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="remains-tr" onclick="document.location.href = '/rem-edit/<?php echo e($tech->id); ?>'">
                <td>
                    <img src="<?php echo e(asset('img/tech/'.$tech->photo)); ?>" class="img-thumbnail h110" />
                </td>
                <td>
                    <?php echo $tech->tech; ?>

                </td>
                <td <?php if($tech->count <= 5): ?> <?php echo e(_('class=td-red')); ?><?php endif; ?>>
                    <?php echo e($tech->model); ?>

                </td>
                <td>
                    <?php echo e($tech->category); ?>

                </td>
                <td <?php if($tech->count <= 5): ?> <?php echo e(_('class=td-red')); ?><?php endif; ?>>
                    <?php echo e($tech->count); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>