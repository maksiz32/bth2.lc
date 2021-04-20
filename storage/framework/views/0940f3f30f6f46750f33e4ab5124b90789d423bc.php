<?php $__env->startSection('title', "Редактирование фото"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <div class="hide" id="blur"></div>
    <?php if(isset($message)): ?>
        <div class="alert alert-danger" role="alert">
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
<main id="formR">
    <form method="post" id="formF" enctype="multipart/form-data">
        <div class="row hide">
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="ldapuser" value="<?php echo e(old('ldapuser', $ldapuser)); ?>">
            <input type="hidden" name="ldappass" value="<?php echo e(old('ldappass', $ldappass)); ?>">
            <input type="hidden" name="companyDN" value="<?php echo e(old('companyDN', $companyDN)); ?>">
        </div>
<?php $__currentLoopData = $ouPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="personline" app-data="<?php echo e($loop->index); ?>" id="line-<?php echo e($loop->index); ?>">
            <input type="hidden" id="dn-<?php echo e($loop->index); ?>" value="<?php echo e($pers['dn']); ?>">
                <div class="personline__img personline__rounded" id="img-<?php echo e($loop->index); ?>" app-data="<?php echo e($loop->index); ?>">
                    <?php if(isset($pers['thumbnailphoto'][0])): ?>
                    <img width="50" height="60" class="personline__rounded" app-data="<?php echo e($loop->index); ?>" 
                        src="<?php echo e('data:image/jpeg;base64,'.base64_encode($pers['thumbnailphoto'][0])); ?>">
                    <?php else: ?>
                    <span class="personline__noimg" app-data="<?php echo e($loop->index); ?>">
                        Нет<wbr> Фото
                    </span>
                    <?php endif; ?>
                </div>
                <p class="personline-txt" app-data="<?php echo e($loop->index); ?>" id="txt-<?php echo e($loop->index); ?>">
                    <strong app-data="<?php echo e($loop->index); ?>">
                        <?php echo e($pers['name'][0]); ?>

                    </strong>
                <?php echo e((isset($pers['title'][0]))?" - ".$pers['title'][0]:''); ?>

                </p>
            <div class="hide personline-group" id="h-<?php echo e($loop->index); ?>">
                <label for="i-<?php echo e($loop->index); ?>">Выберите фото на компьютере, чтобы изменить в Домене</label>
                <input class="personline-group-file" type="file" accept="image/*" 
                id="i-<?php echo e($loop->index); ?>" placeholder="Выберите фото на компьютере, чтобы изменить в Домене">
                <button class="personline-group-btn__submit" type="submit" onclick="sendPhoto(<?php echo e($loop->index); ?>)">
                    Поменять
                </button>
                <button type="reset" onclick="returnModify(<?php echo e($loop->index); ?>)" 
                class="personline-group-btn__reset">Отмена</button>
            </div>
        </section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>
</main>
<script src="<?php echo e(asset('/js/changephoto.js')); ?>"></script>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>