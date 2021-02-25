<?php $__env->startSection('title', "База знаний ИТ - ".$system->system); ?>
<?php $__env->startSection('content'); ?>
<article class="container-fluid main_page top-130">
            <div class="breadcr text-mono" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/wiki">База знаний</a></li>
                    <li class="breadcrumb-item"><?php echo e($system->system); ?></li>
                </ol>
            </div>
    <?php $__currentLoopData = $wiki; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wik): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p class="ml-5">
    <a href="<?php echo e(action('WikiController@wikiOne',['id' => $wik->id])); ?>">
    <?php echo e($loop->iteration.": ".$wik->error." (Раздел: \"".$wik->system."\")"); ?>

    </a>
    </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>