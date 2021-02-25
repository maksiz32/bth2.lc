<?php $__env->startSection('title', "Редактирование записей в AD"); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
<script type="text/javascript">
    function addName(adid, adkey, dn, name) {
        adid = document.getElementById(adid);
        dn = document.getElementById(dn);
	adid.removeAttribute('readonly');
        adid.setAttribute('name', adkey+'['+name+']');
        dn.setAttribute('name', adkey+'[dn]');
  }
</script>
<?php $__env->stopPush(); ?>
<article class="container main_page">
    <?php if($message = Session::get('message')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo e(Session::get('message')); ?>

    </div>
    <?php endif; ?>

    <form action="<?php echo e(action('AdWorkController@adModify')); ?>" method="post">
        <div class="row">
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="ldapuser" value="<?php echo e(old('ldapuser', $ldapuser)); ?>">
            <input type="hidden" name="ldappass" value="<?php echo e(old('ldappass', $ldappass)); ?>">
            <input type="hidden" name="companyDN" value="<?php echo e(old('companyDN', $companyDN)); ?>">
        </div>
        <div class="accordion" id="accordionOne">
            
        <p class="main1"> <!-- Name of my array -->
            <div class="card">
                <div class="card-header text-center alert alert-success" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            ОСП и Дирекция
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionOne">
                    <div class="card-body">
                    
<?php
$i = 1;
?>
<?php $__currentLoopData = $ouRegionsTop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
        <p class="regAD<?php echo e($i); ?>">
            <input type="hidden" id="dn1-<?php echo e($i); ?>" value="<?php echo e($reg['dn']); ?>">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td colspan="3"><?php echo e($reg['name'][0]); ?></td>
                    </tr>
                    <tr>
                        <td width="220">
                            <input type="text" class="form-control-sm col-12" 
                                id="pA1<?php echo e($i); ?>" value="<?php echo e((isset($reg['postaladdress'][0]))?$reg['postaladdress'][0]:''); ?>" readonly 
                                onclick='addName("pA1<?php echo e($i); ?>", "main1[varAD<?php echo e($i); ?>]", "dn1-<?php echo e($i); ?>", "postaladdress");'
                                placeholder="Адрес">
                        </td>
                        <td width="80">
                            <input type="text" class="form-control-sm col-12" 
                                id="pC1<?php echo e($i); ?>" value="<?php echo e((isset($reg['postalcode'][0]))?$reg['postalcode'][0]:''); ?>" readonly 
                                onclick='addName("pC1<?php echo e($i); ?>", "main1[varAD<?php echo e($i); ?>]", "dn1-<?php echo e($i); ?>", "postalcode");'
                                placeholder="Индекс">
                        </td>
                        <td width="220">
                            <?php if($reg['name'][0] != "Дирекция"): ?>
                            <input type="text" class="form-control-sm col-12" 
                                id="tN1<?php echo e($i); ?>" value="<?php echo e((isset($reg['telephonenumber'][0]))?$reg['telephonenumber'][0]:''); ?>" readonly 
                                onclick='addName("tN1<?php echo e($i); ?>", "main1[varAD<?php echo e($i); ?>]", "dn1-<?php echo e($i); ?>", "telephonenumber");'
                                placeholder="Городские телефоны">
                            <?php else: ?>
                            <?php echo e((isset($reg['telephonenumber'][0]))?$reg['telephonenumber'][0]:''); ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
        </p>
<?php
    $i++;
?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </p>
            
        <p class="main2">    
        <div class="card">
                <div class="card-header text-center alert alert-success" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Отделы и группы
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionOne">
                    <div class="card-body">

<?php
$i = 1;
?>
<?php $__currentLoopData = $ouDepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $canName = explode("/", $dep['canonicalname'][0]);
    ?>
        <p class="depAD<?php echo e($i); ?>">
            <input type="hidden" id="dn2-<?php echo e($i); ?>" value="<?php echo e($dep['dn']); ?>">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td colspan="3"><strong><?php echo e($dep['name'][0]); ?></strong> - <?php echo e($canName[4]); ?></td>
                    </tr>
                    <tr>
                        <td width="220">
                            <?php echo (isset($dep['postaladdress'][0]))?$dep['postaladdress'][0]:'<em>Адрес</em>'; ?>

                        </td>
                        <td width="80">
                            <?php echo (isset($dep['postalcode'][0]))?$dep['postalcode'][0]:'<em>Индекс</em>'; ?>

                        </td>
                        <td width="220">
                            <?php if($canName[4] == 'Дирекция'): ?>
                            <input type="text" class="form-control-sm col-12" 
                                id="tN2<?php echo e($i); ?>" value="<?php echo e((isset($dep['telephonenumber'][0]))?$dep['telephonenumber'][0]:''); ?>" readonly 
                                onclick='addName("tN2<?php echo e($i); ?>", "main2[depAD<?php echo e($i); ?>]", "dn2-<?php echo e($i); ?>", "telephonenumber");'
                                placeholder="Городские телефоны">
                            <?php else: ?>
                            <?php echo (isset($dep['telephonenumber'][0]))?$dep['telephonenumber'][0]:'<em>Телефоны</em>'; ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
        </p>
<?php
    $i++;
?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
                    </div>
                </div>
            </div>
        </p>
            
        <p class="main3">    
        <div class="card">
                <div class="card-header text-center alert alert-success" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            Пользователи
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionOne">
                    <div class="card-body">

<?php
$i = 1;
?>
<?php $__currentLoopData = $ouPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p class="perAD<?php echo e($i); ?>">
            <input type="hidden" id="dn3-<?php echo e($i); ?>" value="<?php echo e($pers['dn']); ?>">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td colspan="4">
                            <strong>
                                <?php echo e($pers['name'][0]); ?>

                            </strong>
                            <?php echo e((isset($pers['title'][0]))?" - ".$pers['title'][0]:''); ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="200">
                            <?php echo (isset($pers['postaladdress'][0]))?$pers['postaladdress'][0]:'<em>Адрес</em>'; ?>

                        </td>
                        <td width="80">
                            <?php echo (isset($pers['postalcode'][0]))?$pers['postalcode'][0]:'<em>Индекс</em>'; ?>

                        </td>
                        <td width="180">
                            <?php echo (isset($pers['telephonenumber'][0]))?$pers['telephonenumber'][0]:'<em>Городской телефон</em>'; ?>

                        </td>
                        <td width="120">
                            <input type="text" class="form-control-sm col-12" 
                                id="iN3<?php echo e($i); ?>" value="<?php echo e((isset($pers['ipphone'][0]))?$pers['ipphone'][0]:''); ?>" readonly 
                                onclick='addName("iN3<?php echo e($i); ?>", "main3[perAD<?php echo e($i); ?>]", "dn3-<?php echo e($i); ?>", "ipphone");'
                                placeholder="Внутренний телефон">
                        </td>
                    </tr>
                </table>
        </p>
<?php
    $i++;
?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
                    </div>
                </div>
            </div>
        </p>
            
        </div>
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
            </div>
        </div>
    </form>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nolinks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>