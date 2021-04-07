<?php $__env->startSection('title', "Подтверждение в AD"); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <br/>
    <br/>
    <?php if(isset($message)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo e($message); ?>

    </div>
    <?php endif; ?>

    <form action="<?php echo e(action('AdWorkController@adViewEdit')); ?>" method="post">
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

        <div class="row">
            <input type="hidden" name="ldapuser" value="<?php echo e(old('ldapuser', $ldapuser)); ?>">
            <input type="hidden" name="companyDN" value="<?php echo e(old('companyDN', $companyDN)); ?>">
            <input type="hidden" name="company" value="<?php echo e(old('company', $company)); ?>">
            <div class="col-12 text-center">
                <label for="pass" class="text-left">
                    Подтвердите доменный пароль пользователя 
                    <span><?php echo e($ldapuser); ?> </span> 
                    для работы с подразделением: 
                    <span><?php echo e($company); ?></span>
                </label>
                <input type="password" class="form-control form-control-sm" name="pass" required>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Войти</button>
                <button type="reset" class="btn btn-secondary">Отмена</a>
            </div>
        </div>
    </form>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>