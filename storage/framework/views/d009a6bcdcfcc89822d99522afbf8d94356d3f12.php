<?php $__env->startSection('title', "Категории техники"); ?>
<?php $__env->startSection('content'); ?>
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
        <div class="col-12">
            Категории:
        </div>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12">
                <?php echo e($category->id . ". ". $category->category); ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <form action="<?php echo e(action('TechController@makeCategory')); ?>" method="post">
            <div class="form-row">
    
        <?php if(isset($cat) && $cat->id): ?>
            <?php echo e(method_field('PUT')); ?>

        <input type="hidden" name="id" value="<?php echo e(old('id', $cat->id)); ?>">
        <?php endif; ?>
        <?php echo e(csrf_field()); ?>

            <div class="form-group col-10">
                <label for="number" class="control-label small">Номер машины (6 символов, без пробелов):</label>
                <input type="text" class="form-control" name="number" value="" required>
            </div>
            </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>