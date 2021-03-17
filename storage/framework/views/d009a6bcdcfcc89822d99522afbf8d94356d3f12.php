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
        <?php if(isset($categories)): ?>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12">
                <?php echo e($category->id . ". ". $category->category); ?>

                <a href="/category/<?php echo e($category->id); ?>" class="btn btn-info">Редактировать</a>
                <a href="" class="btn btn-danger">Удалить</a>
            </div>
                <br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <form action="<?php echo e(action('TechController@makeCategory')); ?>" method="post">
            <div class="form-row">
                <?php if(isset($cat) && $cat->id): ?>
                    <?php echo e(method_field('PUT')); ?>

                <input type="hidden" name="id" value="<?php echo e(old('id', $cat->id)); ?>">
                <?php endif; ?>
                <?php echo e(csrf_field()); ?>

                    <div class="form-group col-10">
                        <label for="category" class="control-label small">Название категории:</label>
                        <input type="text" class="form-control" name="category" value="<?php echo e(old('category', $cat->category)); ?>" required>
                    </div>
            </div>
            <button type="submit">Ввод</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>