<?php $__env->startSection('title', "Видео-файлы Филиала"); ?>
<?php $__env->startSection('content'); ?>
<article class="container-fluid main_page top-110">
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(Session::get('success')); ?>

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
<div class="alert alert-dark alert-dismissible fade show" role="alert">
    <form action="<?php echo e(action('AlbumController@searchVideo')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <div class="form-row">
            <div class="col">
                <label for="videoSearch">Поиск видео по названию:</label>
            </div>
            <div class="col">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">?</div>
                    </div>
                    <input type="text" class="form-control" name="videoSearch" id="videoSearch" required="">
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary mb-2">Поиск</button>
            </div>
        </div>
    </form>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
<div class="row">
    <div class="col-12 text-center alert alert-secondary" role="alert">
        <a class="btn btn-primary" role="button" href="/new_video">
            Добавить новое видео
        </a>
    </div>
</div>
    <?php echo e($videos->links()); ?>

    <div class="row justify-content-center">
    <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3 mar15 alert alert-info text-center" role="alert">
        <div class="text-center">
	<div class="video_content">
		<?php echo $video->name; ?>

	</div>	
	<div class="video">
		<video poster="<?php echo e(asset('/img/video_placeholders/'.$video->poster)); ?>" src="<?php echo e(asset('/video/'.$video->file)); ?>" width="320" height="240" controls preload></video>
	</div>
            <p><a href="<?php echo e(action('AlbumController@inputVideo', ['id' => $video->id])); ?>" class="btn btn-primary btn-block">
                        Редактировать
                </a></p>
                <p><a href="<?php echo e(action('AlbumController@deleteVideo', ['id' => $video->id])); ?>" 
                      OnClick="return confirm('Подтвердите удаление элемента')" class="btn btn-danger btn-block">
                        Удалить
                    </a></p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
        <?php echo e($videos->links()); ?>

    <div class="row justify-content-center">
    <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3 mar15 alert alert-info text-center" role="alert">
        <div class="text-center">
	<div class="video_content">
		<?php echo $video->name; ?>

	</div>	
	<div class="video">
		<video poster="<?php echo e(asset('/img/video_placeholders/'.$video->poster)); ?>" src="<?php echo e(asset('/video/'.$video->file)); ?>" width="320" height="240" controls preload></video>
	</div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>    
    <?php endif; ?>
    <?php echo e($videos->links()); ?>

</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>