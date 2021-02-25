<?php $__env->startSection('title', "Добавление / изменение системы в Базe знаний"); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
<div class="container top-130">
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($message = Session::get('danger')): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo e($message); ?>

        </div>
    <?php endif; ?>
    <?php if(count($errors)>0): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(action('WikiController@inputSys')); ?>" method="post">
    <div class="form-row">
        <?php echo e(csrf_field()); ?>

        <?php if($system->id): ?>
        <?php echo e(method_field('PUT')); ?>

            <input type="hidden" name="id" value="<?php echo e(old('id', $system->id)); ?>">
        <?php endif; ?>
            <div class="form-group col-md-9">
                <label for="system" class="control-label">Имя системы:</label>
                <input type="text" class="form-control" name="system" value="<?php echo e(old('system', $system->system)); ?>" required>
            </div>
    </div>
        <?php if($system->id): ?>
        <button type="submit" class="btn btn-primary">Изменить</button>
        <?php else: ?>
        <button type="submit" class="btn btn-primary">Добавить</button>
        <?php endif; ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>