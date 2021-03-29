<?php $__env->startSection('title', "Главная страница Портала"); ?>

<?php $__env->startSection('content'); ?>
<article class="container-fluid main_page top-110">
    <figure class="main_nav">
        <a href="/photo_album">
            <img src="<?php echo e(asset('img/main_menu/photo.png')); ?>" alt="Наши фотоальбомы" title="Наши фотоальбомы">
            <figcaption>
                <strong>Наши альбомы</strong>Здесь можно посмотреть все альбомы с праздников и мероприятий <span class="color_red"> Филиала</span>
            </figcaption>
        </a>
    </figure>
    
    <figure class="main_nav">
        <a href="/all_video">
            <img src="<?php echo e(asset('img/main_menu/video.png')); ?>" alt="Наше видео" title="Наше видео">
            <figcaption>
                <strong>Наше видео</strong>Здесь записи Виртуального Класса и видео с мероприятий <span class="color_red"> Филиала</span>
            </figcaption>
        </a>
    </figure>
    
    <figure class="main_nav">
        <a href="/order">
            <img src="<?php echo e(asset('img/main_menu/order-print.png')); ?>" alt="Заказ расходных материалов" title="Заказ расходных материалов">
            <figcaption>
                <strong>Картриджи</strong>Заказать расходные материалы
            </figcaption>
        </a>
    </figure>
    
    <figure class="main_nav">
        <a href="/links">
            <img src="<?php echo e(asset('img/main_menu/links.png')); ?>" alt="Все полезные ссылки" title="Все полезные ссылки">
            <figcaption>
                <strong>Все полезные ссылки</strong>Здесь собраны все полезные ссылки на внутренние ресурсы <span class="color_red"> Компании</span>
            </figcaption>
        </a>
    </figure>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>