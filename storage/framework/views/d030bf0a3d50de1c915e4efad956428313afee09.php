<?php $__env->startSection('title', "База знаний ИТ - ".$wiki->system." - ".$wiki->error); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('head'); ?>
<style>
    body {
        background-color: #e9e9e9;
    }
    .breadcr {
        margin-bottom: -20px;
    }
    .breadcrumb, .breadcrumb-item {
        background-color: #e9e9e9 !important;
    }
    .fileW {
        font-size: x-small;
    }
    .btnWiki {
        margin: -10px 0 20px 0;
    }
</style>
<script>
$(document).ready(function(){
    $('.hideSpeanerWiki').css('display', 'none');
    $('.btnWiki').css('display', 'inline-block');
    $('.btnWiki').on('click',function(){
        $(this).css('display','none');
        $('.hideSpeanerWiki').css('display', 'block');
    });
});
</script>
<?php $__env->stopPush(); ?>
<article class="container-fluid top-130">
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(Session::get('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if($message = Session::get('danger')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo e($message); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if(count($errors)>0): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
            <div class="breadcr text-mono" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/wiki">База знаний</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(action('WikiController@systemOne',['id'=>$wiki->id_systems])); ?>"><?php echo e($wiki->system); ?></a></li>
                    <li class="breadcrumb-item"><?php echo e($wiki->error); ?></li>
                </ol>
            </div>
    <div class="row mt-3">
        <div class="col-md-9" id="wikiText">
            <div class="redRightBorder">
            <div class="ml-5">
                <h3><?php echo e($wiki->error); ?></h3>
                <hr>
                <?php echo $wiki->fix; ?>

            </div>
            <div class="ml-5 mt-3">
                <a class="btn btn-info" href="<?php echo e(action('WikiController@viewWiki',['id'=>$wiki->id])); ?>">
                    Изменить
                </a>
                <a class="btn btn-danger" href="#" OnClick="return confirm('Подтвердите удаление элемента')">
                    Удалить
                </a>
            </div>
            </div>
        </div>
        <div id="files" class="col-md-3 text-center">
            <?php if(count($files) > 0): ?>
            <div class="row">
            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-6">
            <a href="<?php echo e(asset($file->path)); ?>" target="_blanck">
                <figure>
                    <img src="<?php echo e(asset($file->type)); ?>">
                    <figcaption class="fileW"><?php echo e($file->name); ?></figcaption>
                </figure>
            </a>
                <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
                <a class="btn btn-danger btn-sm btnWiki" 
                   href="<?php echo e(action('WikiController@delFile',['id'=>$file->id])); ?>">
                    Удалить
                </a>
            <div class="hideSpeanerWiki spinner-grow spinner-grow-sm" role="status" 
                 aria-hidden="true" style="display: none">
                Удаляю, подождите
            </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>