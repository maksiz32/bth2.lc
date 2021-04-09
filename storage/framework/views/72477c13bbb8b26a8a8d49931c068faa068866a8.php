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

    <form action="<?php echo e(action('AdWorkController@adViewEdit')); ?>" method="post" id="form-pas">
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
        <h2 class="form-check-title">Выберите дальнейшее действие</h2>
        <section class="form-check-redirect">
        <input class="form-check__input" type="radio" name="redirect-link" id="redirect-link1" 
        value="html" checked>
        <label class="form-check__lable" id="redirect-label1" for="redirect-link1">Внести изменения в УЗ/Получить html-подписи</label>
        <input class="form-check__input" type="radio" name="redirect-link" id="redirect-link2" 
        value="photo">
        <label class="form-check__lable" id="redirect-label2" for="redirect-link2">Изменить фотографии в УЗ</label>
        </section>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Войти</button>
                <button type="reset" class="btn btn-secondary">Отмена</a>
            </div>
        </div>
    </form>
</article>
<script>
    function isCheck() {
        if ($('#redirect-link1').prop('checked')) {
            $('#redirect-label1').addClass('form-check__checked');
            $('#redirect-label2').removeClass('form-check__checked');
        } else {
            $('#redirect-label2').addClass('form-check__checked');
            $('#redirect-label1').removeClass('form-check__checked');
        }
    }
    const locate = window.location.origin;
    $(document).ready(function() {
        $('#redirect-label1').addClass('form-check__checked');
        $('#form-pas').prop('action', locate+'/adlist');
        $('#redirect-label1').on('click', function(){
            $('#redirect-link1').prop('checked', true);
            $('#redirect-link2').prop('checked', false);
            $('#form-pas').prop('action', locate+'/adlist');
            isCheck();
            console.log(locate);
        });
        $('#redirect-label2').on('click', function(){
            $('#redirect-link2').prop('checked', true);
            $('#redirect-link1').prop('checked', false);
            $('#form-pas').prop('action', locate+'/adphotochng');
            isCheck();
        });
    });
    //FOR FUTURE ES6 or mb Babel-converting?:
    // function isCheck() {
    //     let lbl1 = document.getElementById('redirect-label1');
    //     let lbl2 = document.getElementById('redirect-label2');
    //     if (document.getElementById('redirect-link1').hasAttribute('checked')) {
    //         lbl1.classList.add('form-check__checked');
    //         lbl2.classList.remove('form-check__checked');
    //     } else {
    //         lbl1.classList.remove('form-check__checked');
    //         lbl2.classList.add('form-check__checked');
    //     }
    // }
    // const link = document.querySelectorAll('label');
    // for(let el of link) {
    //     el.addEventListener('click', evt => {
    //         let targ = el.getAttribute('for');
    //         let radioB = document.getElementById(targ);
    //         let check = document.querySelector(`[checked]`);
    //         radioB.setAttribute("checked", "");
    //         check.removeAttribute("checked");
    //         isCheck();
    //     })
    // }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>