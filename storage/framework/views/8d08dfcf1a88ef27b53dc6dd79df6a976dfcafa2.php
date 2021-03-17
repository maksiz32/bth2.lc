<?php $__env->startSection('title', "По моделе оборудования"); ?>
<?php $__env->startSection('content'); ?>
<div class="container"> 
        <form action="<?php echo e(action('OrderController@getByFirm',['what' => 't'])); ?>" method="post"> 
            <div class="form-row"> 
                <?php echo e(csrf_field()); ?>

            <div class="form-group col">
                <label for="tech" class="col-12 control-label">Выберите критерий:</label>
                <select name="tech" required>
                    <?php $__currentLoopData = $teches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tech->model); ?>"><?php echo e($tech->tech); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            </div>
            <div class="form-row">
        <button type="submit" class="btn btn-primary">Создать</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
            </div>
        </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>