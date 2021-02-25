<?php $__env->startSection('title', "Создание :: редактирование видеоальбомов Филиала"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(Session::get('success')); ?>

    </div>
    <?php endif; ?>
    <?php if($message = Session::get('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo e(Session::get('error')); ?>

    </div>
    <?php endif; ?>
    <form action="<?php echo e(action('AlbumController@saveVideo')); ?>" method="post" enctype="multipart/form-data">
        
        <?php if(!isset($video->id)): ?>
        <div class="row">
            <div class="col-lg-7">
                <label for="file1">Выберите файл:</label>
                <input type="file" class="form-control-file" name="file1" accept="video/*">
            </div>
        </div>
        <?php endif; ?>
    <div class="form-row">
        <?php echo e(method_field('PUT')); ?>

            <input type="hidden" name="id" value="<?php echo e(old('id', $video->id)); ?>">
        <?php echo e(csrf_field()); ?>

            <div class="form-group col">
                <label for="name" class="control-label">Название видео:</label>
                <input type="text" class="form-control" name="name" value="<?php echo e(old('name', $video->name)); ?>" required>
            </div>
    </div>  
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </form>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>