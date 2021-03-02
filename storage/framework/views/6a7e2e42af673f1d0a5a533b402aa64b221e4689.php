<?php $__env->startSection('title', 'Ввод остатков'); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <form action="<?php echo e(action('TechController@saveRemain')); ?>" method="post">
        Изменить количество расходкников:
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

        <input type="hidden" name="rem_id" value="<?php echo e($rem->rem_id); ?>">
        <input type="hidden" name="tech_id" value="<?php echo e($rem->tech_id); ?>">
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Модель</th>
                <th>Картридж</th>
                <th>Остатки</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php echo $rem->tech; ?>

                </td>
                <td>
                    <?php echo e($rem->model); ?>

                </td>
                <td>
                    <input type="text" name="count" value="<?php echo e($rem->count); ?>">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <button type="submit">Ввод</button>
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>