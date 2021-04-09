<?php $__env->startSection('title', "Редактирование фото"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <?php if($message = Session::get('message')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo e(Session::get('message')); ?>

    </div>
    <?php endif; ?>

    <form action="<?php echo e(action('AdWorkController@adModify')); ?>" method="post" id="formR">
        <div class="row">
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="ldapuser" value="<?php echo e(old('ldapuser', $ldapuser)); ?>">
            <input type="hidden" name="ldappass" value="<?php echo e(old('ldappass', $ldappass)); ?>">
            <input type="hidden" name="companyDN" value="<?php echo e(old('companyDN', $companyDN)); ?>">
        </div>
<?php $__currentLoopData = $ouPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <section class="personline" id="line-<?php echo e($loop->index); ?>" app-data="<?php echo e($loop->index); ?>">
        <input type="hidden" id="dn-<?php echo e($loop->index); ?>" value="<?php echo e($pers['dn']); ?>">
            <div class="personline__img personline__rounded" app-data="<?php echo e($loop->index); ?>">
                <?php if(isset($pers['thumbnailphoto'][0])): ?>
                <img width="60" height="60" class="personline__rounded" app-data="<?php echo e($loop->index); ?>" 
                    src="<?php echo e('data:image/jpeg;base64,'.base64_encode($pers['thumbnailphoto'][0])); ?>">
                <?php else: ?>
                <span class="personline__noimg" app-data="<?php echo e($loop->index); ?>">
                    Нет<wbr> Фото
                </span>
                <?php endif; ?>
            </div>
            <p class="personline-txt" app-data="<?php echo e($loop->index); ?>">
                <strong app-data="<?php echo e($loop->index); ?>">
                    <?php echo e($pers['name'][0]); ?>

                </strong>
            <?php echo e((isset($pers['title'][0]))?" - ".$pers['title'][0]:''); ?>

            </p>
        <div class="hide personline-group" id="h-<?php echo e($loop->index); ?>">
            <label for="h-<?php echo e($loop->index); ?>">Выберите фото на компьютере, чтобы изменить в Домене</label>
            <input class="personline-group-file" type="file" 
            id="i-<?php echo e($loop->index); ?>" placeholder="Выберите фото на компьютере, чтобы изменить в Домене">
        </div>
    </section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <script>
        function modifyInner(id) {
            let el = document.getElementById('h-'+id);
            el.classList.remove('hide');
        }
        document.getElementById('formR').onclick = function(ev) {
            let target = ev.target;
            let targetId = target.getAttribute('app-data');
            if (targetId != null) {
                modifyInner(targetId);
            }
        }
        // el.forEach(function(oneEl) {
        //     let p = oneEl.addEventListener("click", function(){modifyInner(2)}, false);
        //     console.log(p);
        // })
    </script>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="reset" class="btn btn-secondary">Отмена</button>
            </div>
        </div>
    </form>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>