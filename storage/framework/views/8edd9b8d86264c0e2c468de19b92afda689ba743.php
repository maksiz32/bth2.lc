<?php $__env->startSection('title', "Все ССЫЛКИ"); ?>
<?php $__env->startPush('head'); ?>
<script>
    $(document).ready(function() {
        var $countL = $("[name='link']").length;
        console.log($countL);
        var $j=0;
        for($i=1; $i<=$countL; $i++) {
            $('#link'+$i).delay($j).fadeIn(1000);
            $j+=200;
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <?php if($message = Session::get('status')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('status')); ?>

            </div>
            <?php endif; ?>
            <?php if($message = Session::get('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo e(Session::get('error')); ?>

            </div>
            <?php endif; ?>
    <div class="row alert alert-info" role="alert">
        <div class="col-12 text-center">Список ресурсов Компании:
        </div>
    </div>
<noscript>Включите JavaScript в настройках браузера</noscript>
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <div class="row alert alert-danger" role="alert">
        <div class="col-12 text-center">
            <a href="/new_link" class="btn btn-primary">
                Создать ссылки
            </a>
        </div>
    </div>
    <div class="row">
    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(($loop->index % 4 === 0) && (!$loop->first)): ?>
    </div><br/><div class="row">
        <?php endif; ?>
        <div class="col-lg-3">
            <div class="card border-dark text-center" id="link<?php echo e($loop->index + 1); ?>" name="link" style='display: none;'>
                <a href="<?php echo e($link->path); ?>" class="text-dark" target="_blank">
                    <div class="card-body">
                        <h3><b><p class="card-text"><span class="text-link">
                            <?php echo $link->name; ?>

                                    </span></p></b></h3>
                    </div>
                </a>
            <div class="card-footer">
                <a href="<?php echo e(action('LinkController@edit_link', ['id' => $link->id])); ?>" class="btn btn-primary btn-block">
                    Отредактировать ссылку
                </a>
                <a href="<?php echo e(action('LinkController@delete', ['id' => $link->id])); ?>" 
                   OnClick="return confirm('Подтвердите удаление элемента')" 
                   class="btn btn-danger btn-block">
                    Удалить ссылку
                </a>
            </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="row">
    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(($loop->index % 4 === 0) && (!$loop->first)): ?>
    </div><br/><div class="row">
        <?php endif; ?>
        <div class="col-lg-3">
            <div class="card border-dark text-center" id="link<?php echo e($loop->index + 1); ?>" name="link" style='display: none;'>
                <a href="<?php echo e($link->path); ?>" class="text-dark" target="_blank">
                    <div class="card-body">
                        <h3><b><p class="card-text"><span class="text-link">
                            <?php echo $link->name; ?>

                                    </span></p></b></h3>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>