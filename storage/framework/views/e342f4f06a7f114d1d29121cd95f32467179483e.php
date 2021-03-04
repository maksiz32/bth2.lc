<?php $__env->startSection('title', "Все фотоальбомы Филиала"); ?>
<?php $__env->startSection('content'); ?>
<?php
function rndBg() {
    $arrBg = ['alert-primary','alert-secondary','alert-success','alert-danger',
            'alert-warning','alert-info','alert-light','alert-dark'];
    $i = (mt_rand(1, count($arrBg)) - 1);
    echo $arrBg[$i];
}
?>
<article class="container main_page">
<?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <div class="row">
        <div class="col-lg-4 text-center">
            <a class="btn btn-primary" role="button" href="/new_album">
                Создать альбом
            </a>
        </div>
<?php if (count($blocks) >= 1) { ?>
        <div class="col-lg-8 text-center">
        <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target=".bd-example-modal-xl">
              Скрытые альбомы <span class="badge badge-light"><?php echo count($blocks);?></span>
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Скрытые альбомы</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
        <div class="container-fluid">
        <div class="row">
        <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-8">
            <a href="<?php echo e(action('AlbumController@album', ['id' => $block->path])); ?>" class="stretched-link">
                <div class="shadow alert <?php rndBg();?> rounded" role="alert" id="link">
                    <p>
                        <strong>
                            <?php echo e($block->name); ?>

                        </strong>
                    </p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
        <a class="btn btn-primary" role="button" href="<?php echo e(action('AlbumController@editPhotoAlbum', ['id' => $block->id])); ?>">
            Изменить название<br/> и видимость
        </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
<?php } ?>
<?php endif; ?>
    <div class="row mar15 alert alert-info" role="alert">
        <div class="col-12 text-center"><h3>Все фотоальбомы</h3></div>
    </div>
    <?php echo e($albums->links()); ?>

    <div class="row">
    <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <div class="col-lg-10">
    <?php else: ?>
    <div class="col-lg-12">
    <?php endif; ?>
    <a href="<?php echo e(action('AlbumController@album', ['id' => $album->path])); ?>" class="stretched-link">
    <div class="shadow alert <?php rndBg();?> rounded" role="alert" id="link">
    <p>
<strong>
            <?php echo e($album->name); ?>

</strong>

    </p>
    </div>
    </a>
    </div>
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <div class="col-lg-2">
    <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(action('AlbumController@editPhotoAlbum', ['id' => $album->id])); ?>">
        Изменить название и видимость
    </a>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo e($albums->links()); ?>

</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>