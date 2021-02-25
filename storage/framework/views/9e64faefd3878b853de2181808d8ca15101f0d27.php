<?php $__env->startSection('title', "Альбом: ".$name->name); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("headup"); ?>
    <link href="<?php echo e(asset('/css/newfile.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('/js/popper.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush("head"); ?>
<link href="<?php echo e(asset('/css/lightbox.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('/js/lightbox.min.js')); ?>"></script>
<script type="text/javascript">
    function addName(cb, cat) {
        cb = document.getElementById(cb);
        cat = document.getElementById(cat);
	cb.setAttribute('style', 'display:none;');
	cat.setAttribute('style', 'display:block;');
	}
</script>
<?php 
(!$countPhotosOnPage) ? $countPhotosOnPage = 1 : true;
?>
<?php $__env->stopPush(); ?>
<article class="container main_page">
    
<?php 
function beLink($numCount, $countPhotosOnPage, $path) {
    $answer = "";
    if (($numCount != $countPhotosOnPage) || (!$countPhotosOnPage)){
        $answer = "href='http://10.32.1.23/album/$path/$numCount' class='badge badge-secondary'";
    } else {
        $answer = "class='badge badge-light'";
    }
    return $answer;
}
?>
    
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(Session::get('success')); ?>

    </div>
    <?php endif; ?>
<?php if(RGSPortal::isEditor(getenv('REMOTE_USER'))): ?>
<div class="row">
    <div class="col-12 text-center alert alert-secondary" role="alert">
        <a class="btn btn-primary" role="button" href="<?php echo e(action('AlbumController@addInAlbum', ['id' => $name->path])); ?>">
            Добавить фотографии
        </a>
    </div>
</div>
<?php endif; ?>
    <div class="row mar15 alert alert-info text-center" role="alert">
        <div class="col-12 text-center"><?php echo e($name->name); ?> (всего <?php echo e($countP); ?> фотографий)
        </div>
    </div>
<div class="row justify-content-end">
    <div class="col-6 alert alert-secondary">
        Изображений на странице:  
        <a <?php echo beLink(1, $countPhotosOnPage, $name->path); ?>>16</a> 
        <a <?php echo beLink(2, $countPhotosOnPage, $name->path); ?>>32</a>  
        <a <?php echo beLink(3, $countPhotosOnPage, $name->path); ?>>64</a>  
        <a <?php echo beLink(4, $countPhotosOnPage, $name->path); ?>>128</a>  
        <a <?php echo beLink(5, $countPhotosOnPage, $name->path); ?>>все</a>
    </div>
  </div>
        <?php echo e($photos->links()); ?>

        <?php $i=1;?>
        <div class="row text-center">
    <?php if(RGSPortal::isEditor(getenv('REMOTE_USER'))): ?>
    <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-sm-3">
        <div class="card text-center" style="width: 14rem;">
            <a href="<?php echo e(asset('/img/albums/'.$photo->id_albums.'/'.$photo->photo.'?'.mt_rand())); ?>" title="<?php echo e($photo->photo); ?>" data-lightbox="my" data-title="<?php echo e($photo->description); ?>">
            <div style="background-image: 
                 url(<?php echo e(asset('/img/albums/'.$photo->id_albums.'/tmb_'.$photo->photo.'?'.mt_rand())); ?>); 
                 height: 8rem; background-position: center; 
                 background-size: contain; background-repeat: no-repeat;" class="card-img-top">
            </div>
            </a>
            <div class="card-body">
                <div class="row text-center" id="forview-<?php echo e($photo->id); ?>" style="display:none;">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                        <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                    </div>
                </div>
                <div id="forhide-<?php echo e($photo->id); ?>">
                <h5 class="card-title"><?php echo e($photo->photo); ?></h5>
                <a href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'rotate', 'id' => $photo->id, 'num' => '90', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' class="btn btn-primary"><span class="oi oi-action-undo"></span></a>
                <a href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'rotate', 'id' => $photo->id, 'num' => '-90', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' class="btn btn-primary"><span class="oi oi-action-redo"></span></a>
                <a href="<?php echo e(action('AlbumController@deletePhoto', ['id' => $photo->id, 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' class="btn btn-danger">Удалить</a>
                <br/><br/>
                <div class="dropdown">
                    <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Действия
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'brightness', 'id' => $photo->id, 'num' => '-10', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Затемнить (-10)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'brightness', 'id' => $photo->id, 'num' => '10', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Осветлить (+10)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'contrast', 'id' => $photo->id, 'num' => '-10', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Контраст (-10)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'contrast', 'id' => $photo->id, 'num' => '10', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Контраст (+10)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'greyscale', 'id' => $photo->id, 'num' => '0', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Оттенки серого (greyscale)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'gamma', 'id' => $photo->id, 'num' => '1.2', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Гамма-коррекция (1,2)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'blur', 'id' => $photo->id, 'num' => '1', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Размытие (+1)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@actionPhoto', ['action' => 'blur', 'id' => $photo->id, 'num' => '1', 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Размытие (+1)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick='addName("forhide-<?php echo e($photo->id); ?>","forview-<?php echo e($photo->id); ?>")' href="<?php echo e(action('AlbumController@watermark', ['id' => $photo->id, 'countPhotosOnPage' => $countPhotosOnPage, 'page' => $photos->currentPage()])); ?>">
                            Водяной знак
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-3">
            <a href="<?php echo e(asset('/img/albums/'.$photo->id_albums.'/'.$photo->photo)); ?>" title="<?php echo e($photo->photo); ?>" data-lightbox="my" data-title="<?php echo e($photo->description); ?>">
                <img src="<?php echo e(asset('/img/albums/'.$photo->id_albums.'/tmb_'.$photo->photo)); ?>" class="img-thumbnail h150">
            </a>
        </div>
    
    <?php 
    $j=$i%4;
    if(!$j) {
     ?>
    
        </div><br/><div class="row text-center">
            
    <?php  }
    $i++;
     ?>
    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    </div>
        <?php echo e($photos->links()); ?>

</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>